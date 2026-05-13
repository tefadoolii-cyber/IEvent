@extends('layouts.app')

@section('title', 'تعديل مستخدم')

@section('content')

<div class="top-header">
    <h4>تعديل بيانات المستخدم</h4>
    <a href="{{ route('users.index') }}" class="btn btn-back">رجوع</a>
</div>

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">الاسم *</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">البريد الإلكتروني *</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الدور *</label>
                    <select name="role" class="form-select" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" @if($user->hasRole($role->name)) selected @endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">الموظف المرتبط</label>
                    <select name="employee_id" class="form-select">
                        <option value="">-- بدون ربط --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" @if($user->employee_id == $employee->id) selected @endif>{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-save">حفظ التعديل</button>
        </form>
    </div>
</div>

@endsection