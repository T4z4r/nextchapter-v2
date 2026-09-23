<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PublicFormsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_enquiry_is_stored_and_flash_shown(): void
    {
        $response = $this->post(route('enquiries.store'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '07700 900000',
            'package' => 'tier-2-standard',
            'message' => 'I would like to know more.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'type' => 'enquiry',
            'email' => 'jane@example.com',
            'package_interest' => 'tier-2-standard',
        ]);
    }

    public function test_enquiry_validation_rejects_bad_input(): void
    {
        $response = $this->from('/#contact')->post(route('enquiries.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_checkout_intent_records_package_interest(): void
    {
        $response = $this->post(route('checkout.intent'), [
            'package' => 'tier-2-standard',
            'mode' => 'joint',
        ]);

        $response->assertRedirect();

        $message = ContactMessage::query()->where('type', 'checkout')->firstOrFail();
        $this->assertSame('tier-2-standard', $message->package_interest);
        $this->assertSame('joint', $message->billing_mode);
        $this->assertStringContainsString('3,495', $message->message);
    }

    public function test_checkout_intent_rejects_unknown_package(): void
    {
        $response = $this->post(route('checkout.intent'), [
            'package' => 'nope-not-real',
            'mode' => 'individual',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_api_lists_active_packages(): void
    {
        $response = $this->getJson(route('api.packages.index'));

        $response->assertOk()
            ->assertJsonPath('data.1.slug', 'tier-2-standard')
            ->assertJsonPath('data.1.billing_variants.joint.display', '£3,495')
            ->assertJsonMissingPath('data.1.delivery_cost');
    }

    public function test_checkout_options_page_shows_selected_package_and_mode(): void
    {
        $response = $this->get(route('checkout.options', [
            'package' => 'tier-2-standard',
            'billing_variant' => 'joint',
        ]));

        $response->assertOk()
            ->assertSee('Financial Divorce Navigator')
            ->assertSee('data-package-slug="tier-2-standard"', false)
            ->assertSee('value="joint" checked', false)
            ->assertSee('£3,495');
    }

    public function test_checkout_options_page_rejects_unknown_package(): void
    {
        $this->get(route('checkout.options', 'not-a-package'))
            ->assertRedirect(url('/#pricing'))
            ->assertSessionHas('error');
    }

    public function test_api_purchase_proxies_to_remote_package_purchase_api(): void
    {
        config(['services.packages.purchase_url' => 'https://balancepoint.uk/api/packages/purchase']);

        Http::fake([
            'https://balancepoint.uk/api/packages/purchase' => Http::response([
                'checkout_session_id' => 'cs_test_123',
                'url' => 'https://checkout.stripe.com/c/pay/cs_test_123',
            ]),
        ]);

        $response = $this->postJson(route('api.packages.purchase'), [
            'package_slug' => 'tier-2-standard',
            'billing_variant' => 'joint',
            'customer_email' => 'client@example.test',
        ]);

        $response->assertOk()
            ->assertJsonPath('checkout_session_id', 'cs_test_123')
            ->assertJsonPath('url', 'https://checkout.stripe.com/c/pay/cs_test_123');

        Http::assertSent(fn ($request) => $request->url() === 'https://balancepoint.uk/api/packages/purchase'
            && $request['customer_email'] === 'client@example.test'
            && $request['package_slug'] === 'tier-2-standard'
            && $request['billing_variant'] === 'joint');

        $this->assertDatabaseHas('contact_messages', [
            'type' => 'checkout',
            'email' => 'client@example.test',
            'package_interest' => 'tier-2-standard',
            'billing_mode' => 'joint',
        ]);
    }

    public function test_api_purchase_requires_remote_purchase_api_configuration(): void
    {
        config(['services.packages.purchase_url' => null]);

        $this->postJson(route('api.packages.purchase'), [
            'package_slug' => 'tier-2-standard',
            'billing_variant' => 'individual',
            'customer_email' => 'client@example.test',
        ])->assertStatus(503);
    }

    public function test_api_webhook_records_completed_checkout_in_testing_without_signature(): void
    {
        $this->postJson(route('api.stripe.webhook'), [
            'id' => 'evt_test_checkout_completed',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => 'cs_test_123',
                    'payment_intent' => 'pi_test_123',
                    'customer_email' => 'client@example.test',
                    'metadata' => [
                        'package_slug' => 'tier-2-standard',
                        'billing_variant' => 'individual',
                    ],
                ],
            ],
        ])->assertOk()->assertJsonPath('received', true);

        $this->assertDatabaseHas('contact_messages', [
            'type' => 'checkout',
            'email' => 'client@example.test',
            'package_interest' => 'tier-2-standard',
            'billing_mode' => 'individual',
        ]);
    }
}
