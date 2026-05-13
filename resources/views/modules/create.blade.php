@extends('layouts.app')

@section('title', 'إضافة إدارة')

@section('content')

<div class="top-header">
    <h4>إضافة إدارة جديدة</h4>
    <a href="{{ route('modules.index') }}" class="btn btn-back">
        <i class="bi bi-arrow-right"></i> رجوع
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <p class="mb-0">{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('modules.store') }}" method="POST">
            @csrf

            <div class="section-title">معلومات الإدارة</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">اسم الإدارة *</label>
                    <input type="text" name="name" class="form-control" placeholder="مثال: إدارة المالية" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المفتاح (إنجليزي) *</label>
                    <input type="text" name="key" class="form-control" placeholder="مثال: finance" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الإدارة الرئيسية *</label>
                    <select name="parent" class="form-select" required>
                        <option value="">-- اختر --</option>
                        <option value="hr">إدارة الموارد البشرية</option>
                        <option value="data">إدارة البيانات</option>
                        <option value="ops">إدارة التشغيل</option>
                        <option value="quality">إدارة الجودة</option>
                        <option value="it">إدارة تقنية المعلومات</option>
                        <option value="finance">إدارة المالية</option>
                        <option value="other">أخرى</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الأيقونة (Bootstrap Icon)</label>
                    <input type="text" name="icon" class="form-control" placeholder="مثال: bi-cash">
                    <small style="color:#9ca3af">من <a href="https://icons.getbootstrap.com" target="_blank">icons.getbootstrap.com</a></small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الرابط (Route Name)</label>
                    <input type="text" name="route" class="form-control" placeholder="مثال: finance.index">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الترتيب</label>
                    <input type="number" name="order" class="form-control" value="1">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-lg"></i> حفظ
                </button>
                <a href="{{ route('modules.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@endsection