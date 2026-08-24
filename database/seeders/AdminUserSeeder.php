<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => config('site.admin_email', 'admin@nextchapter.uk')],
            [
                'name' => 'Site Administrator',
                'password' => Hash::make(config('site.admin_password', 'ChangeMe!2026')),
                'is_admin' => true,
            ]
        );
    }
}
