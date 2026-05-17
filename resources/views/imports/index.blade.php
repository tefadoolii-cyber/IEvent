@extends('layouts.app')
@section('title', 'استيراد البيانات')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-file-earmark-arrow-up"></i> استيراد البيانات من Excel</h4>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

@if(session('import_errors'))
<div class="alert alert-warning alert-dismissible fade show">
    <strong>تحذيرات أثناء الاستيراد:</strong>
    <ul class="mb-0 mt-2">
        @foreach(session('import_errors') as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="row g-4">

    {{-- استيراد الموظفين --}}
    <div class="col-md-4">
        <div class="card" style="height:100%">
            <div class="card-header" style="background:#eff6ff">
                <span style="font-weight:700;color:#1d4ed8"><i class="bi bi-people"></i> استيراد الموظفين</span>
            </div>
            <div class="card-body" style="padding:20px">
                <p style="font-size:13px;color:#6b7280">يجب أن يحتوي الملف على الأعمدة التالية:</p>
                <div style="background:#f9fafb;padding:10px;border-radius:8px;font-size:12px;font-family:monospace;margin-bottom:16px;color:#374151">
                    name, employee_number, email, phone, department, position, hire_date, status
                </div>
                <a href="{{ route('imports.template', 'employees') }}" class="btn btn-back w-100 mb-3" style="font-size:13px">
                    <i class="bi bi-download"></i> تحميل نموذج CSV
                </a>
                <form action="{{ route('imports.employees') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="font-size:13px">اختر الملف (xlsx, xls, csv)</label>
                        <input type="file" name="file" class="form-control" style="font-size:13px" accept=".xlsx,.xls,.csv">
                    </div>
                    <button type="submit" class="btn btn-save w-100"><i class="bi bi-upload"></i> استيراد</button>
                </form>
            </div>
        </div>
    </div>

    {{-- استيراد الشركات --}}
    <div class="col-md-4">
        <div class="card" style="height:100%">
            <div class="card-header" style="background:#f0fdf4">
                <span style="font-weight:700;color:#15803d"><i class="bi bi-building"></i> استيراد الشركات</span>
            </div>
            <div class="card-body" style="padding:20px">
                <p style="font-size:13px;color:#6b7280">يجب أن يحتوي الملف على الأعمدة التالية:</p>
                <div style="background:#f9fafb;padding:10px;border-radius:8px;font-size:12px;font-family:monospace;margin-bottom:16px;color:#374151">
                    name, email, phone, address
                </div>
                <a href="{{ route('imports.template', 'companies') }}" class="btn btn-back w-100 mb-3" style="font-size:13px">
                    <i class="bi bi-download"></i> تحميل نموذج CSV
                </a>
                <form action="{{ route('imports.companies') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="font-size:13px">اختر الملف (xlsx, xls, csv)</label>
                        <input type="file" name="file" class="form-control" style="font-size:13px" accept=".xlsx,.xls,.csv">
                    </div>
                    <button type="submit" class="btn btn-save w-100"><i class="bi bi-upload"></i> استيراد</button>
                </form>
            </div>
        </div>
    </div>

    {{-- استيراد المواقع --}}
    <div class="col-md-4">
        <div class="card" style="height:100%">
            <div class="card-header" style="background:#fefce8">
                <span style="font-weight:700;color:#a16207"><i class="bi bi-geo-alt"></i> استيراد المواقع</span>
            </div>
            <div class="card-body" style="padding:20px">
                <p style="font-size:13px;color:#6b7280">يجب أن يحتوي الملف على الأعمدة التالية:</p>
                <div style="background:#f9fafb;padding:10px;border-radius:8px;font-size:12px;font-family:monospace;margin-bottom:16px;color:#374151">
                    name, address, lat, lng
                </div>
                <a href="{{ route('imports.template', 'locations') }}" class="btn btn-back w-100 mb-3" style="font-size:13px">
                    <i class="bi bi-download"></i> تحميل نموذج CSV
                </a>
                <form action="{{ route('imports.locations') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="font-size:13px">اختر الملف (xlsx, xls, csv)</label>
                        <input type="file" name="file" class="form-control" style="font-size:13px" accept=".xlsx,.xls,.csv">
                    </div>
                    <button type="submit" class="btn btn-save w-100"><i class="bi bi-upload"></i> استيراد</button>
                </form>
            </div>
        </div>
    </div>

</div>

<div class="card mt-4">
    <div class="card-body" style="padding:16px;font-size:13px;color:#6b7280">
        <i class="bi bi-info-circle" style="color:#3b82f6"></i>
        <strong> تعليمات الاستيراد:</strong>
        <ul style="margin-top:8px;margin-bottom:0;padding-right:20px">
            <li>تأكد من أن الصف الأول يحتوي على أسماء الأعمدة كما هو محدد أعلاه</li>
            <li>يدعم النظام صيغ xlsx, xls, csv بحد أقصى 5 ميجابايت</li>
            <li>الصفوف التي تحتوي على أخطاء ستُتخطى وتظهر في تقرير التحذيرات</li>
            <li>بالنسبة للموظفين، إذا كان رقم الموظف موجوداً مسبقاً، سيُتخطى الصف</li>
        </ul>
    </div>
</div>
@endsection
