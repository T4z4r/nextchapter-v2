<?php

namespace Tests\Feature;

use App\Models\PageVisit;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteVisitTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        $this->seed(AdminUserSeeder::class);

        return User::where('is_admin', true)->firstOrFail();
    }

    public function test_home_page_get_is_tracked(): void
    {
        $this->get('/')->assertOk();

        $this->assertDatabaseHas('page_visits', ['path' => '/', 'method' => 'GET']);
        $this->assertSame(1, PageVisit::todayCount());
    }

    public function test_multiple_pages_are_tracked(): void
    {
        $this->get('/');
        $this->get('/legal');

        $this->assertSame(2, PageVisit::total());
        $this->assertSame(2, PageVisit::todayCount());

        $series = PageVisit::dailySeries(14);
        $this->assertCount(14, $series);
        $this->assertSame(2, array_sum($series));
        $this->assertSame(2, $series[now()->toDateString()]);
    }

    public function test_admin_routes_are_not_tracked(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin')
            ->assertOk();

        $this->assertSame(0, PageVisit::count());
    }

    public function test_guests_cannot_view_visits_page(): void
    {
        $this->get(route('admin.visits.index'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_visits_page(): void
    {
        $this->get('/');
        $this->get('/legal');

        $this->actingAs($this->admin())
            ->get(route('admin.visits.index'))
            ->assertOk()
            ->assertSee('Site visits')
            ->assertSee('/legal')
            ->assertSee('/')
            ->assertSeeInOrder(['Visits today', 'Unique visitors today', 'All-time visits']);
    }
}