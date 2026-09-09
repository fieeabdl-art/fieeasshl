<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the default Admin CMS account.
     */
    public function run(): void
    {
        Admin::query()->firstOrCreate(
            ['email' => 'admin@bumiyuji.test'],
            [
                'name' => 'Admin BumiYuji',
                'password' => 'password',
            ]
        );
    }
}
