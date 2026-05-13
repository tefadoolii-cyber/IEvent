<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('_', $item->name)[1] ?? 'other';
        });
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'تم إضافة الدور بنجاح');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('_', $item->name)[1] ?? 'other';
        });
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'تم تعديل الدور بنجاح');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['admin', 'employee'])) {
            return redirect()->route('roles.index')->with('error', 'لا يمكن حذف الأدوار الأساسية');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'تم حذف الدور');
    }
}
