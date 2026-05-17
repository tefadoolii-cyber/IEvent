<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            RolesAndPermissionsSeeder::class,
            LookupSeeder::class,
            ModulesSeeder::class,
        ]);

        // إنشاء مستخدم الأدمن الافتراضي
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'مدير النظام',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole('admin');
    }
}
