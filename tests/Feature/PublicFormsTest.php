<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
