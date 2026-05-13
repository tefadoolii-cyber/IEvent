<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // معلومات المنصة
            ['key' => 'platform_name_en',  'value' => 'iEvent',           'type' => 'text',  'group' => 'branding'],
            ['key' => 'platform_name_ar',  'value' => 'نظام الفعاليات',  'type' => 'text',  'group' => 'branding'],
            ['key' => 'platform_logo',     'value' => null,                'type' => 'image', 'group' => 'branding'],
            ['key' => 'platform_favicon',  'value' => null,                'type' => 'image', 'group' => 'branding'],

            // الألوان
            ['key' => 'primary_color',     'value' => '#4ade80',           'type' => 'color', 'group' => 'theme'],
            ['key' => 'sidebar_color',     'value' => '#1a1a2e',           'type' => 'color', 'group' => 'theme'],
            ['key' => 'background_color',  'value' => '#f4f6f9',           'type' => 'color', 'group' => 'theme'],

            // معلومات الاتصال
            ['key' => 'contact_email',     'value' => 'info@ievent.com',   'type' => 'text',  'group' => 'general'],
            ['key' => 'contact_phone',     'value' => '+966500000000',     'type' => 'text',  'group' => 'general'],
            ['key' => 'company_name',      'value' => 'شركة الفعاليات',    'type' => 'text',  'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
