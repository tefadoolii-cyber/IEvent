<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // الإدارات في النظام
        $modules = [
            'employees'    => 'الموظفين',
            'attendance'   => 'الحضور',
            'users'        => 'المستخدمين',
            'companies'    => 'الشركات',
            'locations'    => 'المواقع',
            'teams'        => 'الفرق',
            'shifts'       => 'الورديات',
            'tasks'        => 'المهام',
            'visits'       => 'الزيارات',
            'evaluations'  => 'التقييمات',
            'assets'       => 'العهد',
            'reports'      => 'التقارير',
        ];

        // الأفعال لكل إدارة
        $actions = ['view', 'create', 'edit', 'delete', 'approve', 'withdraw'];

        // إنشاء الصلاحيات
        foreach ($modules as $module => $name) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name'       => $action . '_' . $module,
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}
