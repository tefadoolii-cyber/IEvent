<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModulesSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            // الموارد البشرية
            ['key' => 'employees',   'name' => 'إدارة الموظفين',         'icon' => 'bi-person',          'route' => 'employees.index',  'parent' => 'hr',      'order' => 1],
            ['key' => 'attendance',  'name' => 'إدارة الحضور والانصراف', 'icon' => 'bi-calendar-check',  'route' => 'attendance.index', 'parent' => 'hr',      'order' => 2],
            ['key' => 'contracts',   'name' => 'إدارة العقود',            'icon' => 'bi-file-earmark-text','route' => 'contracts.index',  'parent' => 'hr',      'order' => 3],

            // البيانات
            ['key' => 'companies',   'name' => 'إدارة الشركات',          'icon' => 'bi-building',        'route' => null,               'parent' => 'data',    'order' => 1],
            ['key' => 'packages',    'name' => 'إدارة الباقات',          'icon' => 'bi-box',             'route' => null,               'parent' => 'data',    'order' => 2],
            ['key' => 'locations',   'name' => 'إدارة المواقع',          'icon' => 'bi-geo-alt',         'route' => null,               'parent' => 'data',    'order' => 3],
            ['key' => 'surveys',     'name' => 'إدارة الاستبيانات',      'icon' => 'bi-clipboard',       'route' => null,               'parent' => 'data',    'order' => 4],
            ['key' => 'imports',     'name' => 'استيراد البيانات',       'icon' => 'bi-upload',          'route' => null,               'parent' => 'data',    'order' => 5],

            // التشغيل
            ['key' => 'teams',       'name' => 'إدارة الفرق الميدانية',  'icon' => 'bi-people',          'route' => null,               'parent' => 'ops',     'order' => 1],
            ['key' => 'assignments', 'name' => 'إدارة الإسنادات',        'icon' => 'bi-person-check',    'route' => null,               'parent' => 'ops',     'order' => 2],
            ['key' => 'visits',      'name' => 'إدارة الزيارات',         'icon' => 'bi-car-front',       'route' => null,               'parent' => 'ops',     'order' => 3],
            ['key' => 'alerts',      'name' => 'إدارة التنبيهات',        'icon' => 'bi-bell',            'route' => null,               'parent' => 'ops',     'order' => 4],
            ['key' => 'shifts',      'name' => 'إدارة الورديات',         'icon' => 'bi-clock',           'route' => null,               'parent' => 'ops',     'order' => 5],
            ['key' => 'regions',     'name' => 'إدارة المناطق',          'icon' => 'bi-map',             'route' => null,               'parent' => 'ops',     'order' => 6],

            // الجودة
            ['key' => 'evaluations',  'name' => 'إدارة التقييمات',         'icon' => 'bi-star',            'route' => null, 'parent' => 'quality', 'order' => 1],
            ['key' => 'readiness',    'name' => 'إدارة رخصة الجاهزية',     'icon' => 'bi-patch-check',     'route' => null, 'parent' => 'quality', 'order' => 2],
            ['key' => 'camp_reports', 'name' => 'تأكيد تقارير المخيمات',    'icon' => 'bi-file-check',      'route' => null, 'parent' => 'quality', 'order' => 3],
            ['key' => 'notes',        'name' => 'إدارة الملاحظات',         'icon' => 'bi-chat-left-text',  'route' => null, 'parent' => 'quality', 'order' => 4],
            ['key' => 'note_types',   'name' => 'أنواع الملاحظات',         'icon' => 'bi-tags',            'route' => null, 'parent' => 'quality', 'order' => 5],

            // تقنية المعلومات
            ['key' => 'users',        'name' => 'إدارة المستخدمين',        'icon' => 'bi-person-gear',     'route' => 'users.index',  'parent' => 'it', 'order' => 1],
            ['key' => 'roles',        'name' => 'إدارة الأدوار والصلاحيات', 'icon' => 'bi-shield-lock',     'route' => 'roles.index',  'parent' => 'it', 'order' => 2],
            ['key' => 'modules',      'name' => 'إدارة الإدارات',           'icon' => 'bi-grid-3x3-gap',    'route' => 'modules.index','parent' => 'it', 'order' => 3],
            ['key' => 'integrations', 'name' => 'إدارة التكاملات',         'icon' => 'bi-plug',            'route' => null,           'parent' => 'it', 'order' => 4],
        ];

        foreach ($modules as $module) {
            Module::firstOrCreate(['key' => $module['key']], $module);
        }
    }
}