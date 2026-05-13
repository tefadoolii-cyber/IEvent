<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                // التعامل مع الصور
                if ($setting->type == 'image' && $request->hasFile("settings.$key")) {
                    $file = $request->file("settings.$key");
                    $path = $file->store('settings', 'public');
                    $setting->update(['value' => $path]);
                } elseif ($setting->type != 'image') {
                    $setting->update(['value' => $value]);
                }
            }
        }

        return redirect()->route('settings.index')->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}
