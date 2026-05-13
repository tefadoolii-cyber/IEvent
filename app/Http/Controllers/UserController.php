<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('employee', 'roles')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $employees = Employee::all();
        $roles = Role::all();
        return view('users.create', compact('employees', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'employee_id' => $request->employee_id,
        ]);

        $user->assignRole($request->role);
        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function show(User $user)
    {
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $employees = Employee::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'employees', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required',
        ]);

        $data = [
            'name'        => $request->name,
            'email'       => $request->email,
            'employee_id' => $request->employee_id,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'تم تعديل المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم');
    }
}