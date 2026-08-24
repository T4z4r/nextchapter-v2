<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\Plan;
use App\Models\Step;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected function seedSite(): void
    {
        $this->seed(ContentSeeder::class);
    }

    public function test_home_page_renders_all_sections(): void
    {
        $this->seedSite();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Reach the right settlement', false);
        $response->assertSee('Everything auto-populates');
        $response->assertSee('Settlement analysis, scenario modelling &amp; negotiation', false);
        $response->assertSee('DIY Financial Navigator');
        $response->assertSee('Financial Clarity Session');
        $response->assertSee('The things people ask us most.');
        $response->assertSee('Begin your next chapter with clarity.');
        $response->assertSee('Send us a message');
    }

    public function test_inactive_content_is_hidden(): void
    {
        $this->seedSite();

        Step::query()->where('title', 'Conclude')->update(['is_active' => false]);
        Faq::query()->limit(1)->update(['is_active' => false]);
        Plan::query()->where('slug', 'tier-3-complete')->update(['is_active' => false]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertDontSee('Export your complete and agreed settlement financials')
            ->assertDontSee('Complete Financial Package')
            ->assertSee('DIY Financial Navigator');
    }

    public function test_pricing_shows_individual_prices_by_default_and_joint_data_attributes(): void
    {
        $this->seedSite();

        $response = $this->get('/');
        $plan = Plan::query()->where('slug', 'tier-2-standard')->firstOrFail();

        $response->assertSee('data-ind="' . number_format($plan->price_ind) . '"', false)
            ->assertSee('data-joint="' . number_format($plan->price_joint) . '"', false);
    }

    public function test_tutorial_lock_state_renders(): void
    {
        $this->seedSite();

        $response = $this->get('/');

        $response->assertSee('tut locked')
            ->assertSee('4:12');
    }
}
