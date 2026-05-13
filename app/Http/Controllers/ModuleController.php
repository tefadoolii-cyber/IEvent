<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::orderBy('parent')->orderBy('order')->get()->groupBy('parent');
        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        return view('modules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key'    => 'required|unique:modules,key',
            'name'   => 'required',
            'parent' => 'required',
        ]);

        Module::create($request->all());
        return redirect()->route('modules.index')->with('success', 'تم إضافة الإدارة بنجاح');
    }

    public function edit(Module $module)
    {
        return view('modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'key'    => 'required|unique:modules,key,' . $module->id,
            'name'   => 'required',
            'parent' => 'required',
        ]);

        $module->update($request->all());
        return redirect()->route('modules.index')->with('success', 'تم تعديل الإدارة بنجاح');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.index')->with('success', 'تم حذف الإدارة');
    }

    // تفعيل/إيقاف إدارة
    public function toggle(Module $module)
    {
        $module->update(['is_active' => !$module->is_active]);
        return redirect()->route('modules.index')->with('success', 'تم تحديث حالة الإدارة');
    }
}
