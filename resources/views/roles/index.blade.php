@extends('layouts.app')

@section('title', 'إدارة الأدوار والصلاحيات')

@section('content')

<div class="top-header">
    <h4>إدارة الأدوار والصلاحيات</h4>
    <a href="{{ route('roles.create') }}" class="btn btn-add">إضافة دور</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">قائمة الأدوار</span>
        <span style="color:#9ca3af; font-size:13px;">إجمالي: {{ count($roles) }} دور</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الدور</th>
                    <th>عدد الصلاحيات</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight:600">{{ $role->name }}</td>
                    <td><span class="badge-active">{{ count($role->permissions) }} صلاحية</span></td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-edit">تعديل</a>
                        @if(!in_array($role->name, ['admin', 'employee']))
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
