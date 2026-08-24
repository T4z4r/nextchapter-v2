<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\AdminUserSeeder;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->get('/admin/steps')->assertRedirect(route('admin.login'));
    }

    public function test_login_page_renders(): void
    {
        $this->get('/admin/login')->assertOk()->assertSee('Next Chapter admin');
    }

    public function test_non_admin_user_is_rejected(): void
    {
        $this->seed(AdminUserSeeder::class);

        User::query()->create([
            'name' => 'Plain User',
            'email' => 'plain@example.com',
            'password' => 'password',
            'is_admin' => false,
        ]);

        $response = $this->post(route('admin.login.attempt'), [
            'email' => 'plain@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_log_in_and_view_dashboard(): void
    {
        $this->seed(AdminUserSeeder::class);

        $response = $this->post(route('admin.login.attempt'), [
            'email' => config('site.admin_email'),
            'password' => config('site.admin_password'),
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();

        $this->actingAs(User::query()->where('email', config('site.admin_email'))->first())
            ->get('/admin')
            ->assertOk()
            ->assertSee('Dashboard');
    }

    public function test_admin_can_log_out(): void
    {
        $this->seed(AdminUserSeeder::class);
        $admin = User::query()->where('email', config('site.admin_email'))->first();

        $this->actingAs($admin)
            ->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }
}
