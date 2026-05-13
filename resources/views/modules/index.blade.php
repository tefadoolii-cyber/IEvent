@extends('layouts.app')

@section('title', 'إدارة الإدارات')

@section('content')

<div class="top-header">
    <h4>إدارة الإدارات</h4>
    <a href="{{ route('modules.create') }}" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> إضافة إدارة
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@php
$parentNames = [
    'hr'      => 'إدارة الموارد البشرية',
    'data'    => 'إدارة البيانات',
    'ops'     => 'إدارة التشغيل',
    'quality' => 'إدارة الجودة',
    'it'      => 'إدارة تقنية المعلومات',
];
@endphp

@foreach($modules as $parent => $items)
<div class="card mb-3">
    <div class="card-header">
        <span style="font-weight:600; font-size:15px">{{ $parentNames[$parent] ?? $parent }}</span>
        <span style="color:#9ca3af; font-size:13px">{{ count($items) }} إدارة</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الأيقونة</th>
                    <th>اسم الإدارة</th>
                    <th>المفتاح</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $module)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><i class="{{ $module->icon }}" style="font-size:18px; color:#4ade80"></i></td>
                    <td style="font-weight:600">{{ $module->name }}</td>
                    <td><code style="background:#f3f4f6; padding:2px 8px; border-radius:4px">{{ $module->key }}</code></td>
                    <td>{{ $module->order }}</td>
                    <td>
                        @if($module->is_active)
                            <span class="badge-active">نشط</span>
                        @else
                            <span class="badge-inactive">مخفي</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('modules.toggle', $module->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-edit" type="submit">
                                @if($module->is_active)
                                    <i class="bi bi-eye-slash"></i> إخفاء
                                @else
                                    <i class="bi bi-eye"></i> إظهار
                                @endif
                            </button>
                        </form>
                        <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-edit">
                            <i class="bi bi-pencil"></i> تعديل
                        </a>
                        <form action="{{ route('modules.destroy', $module->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">
                                <i class="bi bi-trash"></i> حذف
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach

@endsection