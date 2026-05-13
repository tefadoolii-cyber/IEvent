<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الـ Roles
        $admin      = Role::create(['name' => 'admin']);
        $supervisor = Role::create(['name' => 'supervisor']);
        $field      = Role::create(['name' => 'field_officer']);
        $employee   = Role::create(['name' => 'employee']);
        $quality    = Role::create(['name' => 'quality']);
        $data       = Role::create(['name' => 'data']);

        // تعيين Admin للمستخدم الأول
        $user = User::where('email', 'admin@admin.com')->first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}