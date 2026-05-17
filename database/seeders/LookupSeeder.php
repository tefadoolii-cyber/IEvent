<?php

namespace Database\Seeders;

use App\Models\LookupGroup;
use App\Models\Lookup;
use Illuminate\Database\Seeder;

class LookupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            [
                'key' => 'departments',
                'name_ar' => 'الأقسام',
                'is_system' => false,
                'items' => ['الموارد البشرية', 'تقنية المعلومات', 'المالية والمحاسبة', 'المبيعات والتسويق', 'العمليات', 'خدمة العملاء'],
            ],
            [
                'key' => 'job_titles',
                'name_ar' => 'المسميات الوظيفية',
                'is_system' => false,
                'items' => ['مدير', 'مشرف', 'موظف', 'محاسب', 'مطور برمجيات', 'مصمم', 'محلل بيانات', 'مندوب مبيعات'],
            ],
            [
                'key' => 'location_types',
                'name_ar' => 'أنواع المواقع',
                'is_system' => true,
                'items' => ['مركز ضيافة', 'فندق', 'مخيم', 'قاعة', 'مكتب'],
            ],
            [
                'key' => 'contract_statuses',
                'name_ar' => 'حالات العقود',
                'is_system' => true,
                'items' => [
                    ['value_ar' => 'نشط', 'color' => '#10b981'],
                    ['value_ar' => 'منتهي', 'color' => '#6b7280'],
                    ['value_ar' => 'معلق', 'color' => '#f59e0b'],
                    ['value_ar' => 'ملغي', 'color' => '#ef4444'],
                ],
            ],
            [
                'key' => 'event_types',
                'name_ar' => 'أنواع الأحداث',
                'is_system' => true,
                'items' => ['موسم حج', 'موسم عمرة', 'مؤتمر', 'معرض', 'فعالية'],
            ],
            [
                'key' => 'note_types',
                'name_ar' => 'أنواع الملاحظات',
                'is_system' => true,
                'items' => ['ملاحظة عامة', 'تنبيه', 'مخالفة', 'إنجاز'],
            ],
            [
                'key' => 'nationalities',
                'name_ar' => 'الجنسيات',
                'is_system' => true,
                'items' => ['سعودي', 'مصري', 'سوداني', 'يمني', 'باكستاني', 'هندي', 'فلبيني', 'بنغلاديشي'],
            ],
            [
                'key' => 'rating_grades',
                'name_ar' => 'درجات التقييم',
                'is_system' => true,
                'items' => [
                    ['value_ar' => 'ممتاز', 'color' => '#10b981'],
                    ['value_ar' => 'جيد جداً', 'color' => '#3b82f6'],
                    ['value_ar' => 'جيد', 'color' => '#f59e0b'],
                    ['value_ar' => 'مقبول', 'color' => '#f97316'],
                    ['value_ar' => 'ضعيف', 'color' => '#ef4444'],
                ],
            ],
        ];

        foreach ($groups as $groupData) {
            $items = $groupData['items'];
            unset($groupData['items']);

            $group = LookupGroup::updateOrCreate(
                ['key' => $groupData['key']],
                $groupData
            );

            foreach ($items as $i => $item) {
                if (is_string($item)) {
                    $item = ['value_ar' => $item];
                }
                $item['sort_order'] = $i + 1;

                Lookup::updateOrCreate(
                    ['group_id' => $group->id, 'value_ar' => $item['value_ar']],
                    $item
                );
            }
        }
    }
}
