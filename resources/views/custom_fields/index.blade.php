@extends('layouts.app')

@section('title', 'الحقول المخصصة')

@section('content')

<div class="top-header">
    <h4>الحقول المخصصة</h4>
    <a href="{{ route('custom-fields.create') }}" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> إضافة حقل جديد
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@php
$tableNames = [
    'employees'    => 'الموظفين',
    'attendance'   => 'الحضور',
    'contracts'    => 'العقود',
    'companies'    => 'الشركات',
    'locations'    => 'المواقع',
    'tasks'        => 'المهام',
    'visits'       => 'الزيارات',
];
$fieldTypes = [
    'text'     => 'نص',
    'number'   => 'رقم',
    'date'     => 'تاريخ',
    'select'   => 'قائمة منسدلة',
    'textarea' => 'نص طويل',
    'email'    => 'بريد إلكتروني',
    'phone'    => 'جوال',
];
@endphp

@forelse($fields as $tableName => $tableFields)
<div class="card mb-3">
    <div class="card-header">
        <span style="font-weight:600; font-size:15px">{{ $tableNames[$tableName] ?? $tableName }}</span>
        <span style="color:#9ca3af; font-size:13px">{{ count($tableFields) }} حقل</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الحقل</th>
                    <th>المفتاح</th>
                    <th>النوع</th>
                    <th>إلزامي</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tableFields as $field)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight:600">{{ $field->field_label }}</td>
                    <td><code style="background:#f3f4f6; padding:2px 8px; border-radius:4px">{{ $field->field_key }}</code></td>
                    <td>{{ $fieldTypes[$field->field_type] ?? $field->field_type }}</td>
                    <td>
                        @if($field->is_required)
                            <span class="badge-active">إلزامي</span>
                        @else
                            <span class="badge-inactive">اختياري</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('custom-fields.edit', $field->id) }}" class="btn btn-edit">تعديل</a>
                        <form action="{{ route('custom-fields.destroy', $field->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="card">
    <div class="card-body text-center py-5" style="color:#9ca3af">
        <i class="bi bi-plus-square" style="font-size:50px"></i>
        <p class="mt-3">لا يوجد حقول مخصصة بعد</p>
        <a href="{{ route('custom-fields.create') }}" class="btn btn-add">إضافة أول حقل</a>
    </div>
</div>
@endforelse

@endsection