<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\LookupGroupController;
use App\Http\Controllers\LookupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // البروفايل
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // الموظفين والحضور
    Route::resource('employees', EmployeeController::class);
    Route::resource('attendance', AttendanceController::class);

    // المستخدمين
    Route::resource('users', UserController::class);

    // الأدوار والصلاحيات
    Route::resource('roles', RoleController::class);

    // الإدارات (Modules)
    Route::resource('modules', ModuleController::class);
    Route::patch('modules/{module}/toggle', [ModuleController::class, 'toggle'])->name('modules.toggle');

    // الإعدادات
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    // الحقول المخصصة
    Route::resource('custom-fields', CustomFieldController::class);

    // التعريفات الإستعلامية (Lookups)
    Route::resource('lookup-groups', LookupGroupController::class)
        ->except(['create', 'show', 'edit']);
    Route::resource('lookups', LookupController::class)
        ->only(['store', 'update', 'destroy']);
});

require __DIR__.'/auth.php';