@extends('layouts.app')

@section('title', 'إضافة دور')

@section('content')

<div class="top-header">
    <h4>إضافة دور جديد</h4>
    <a href="{{ route('roles.index') }}" class="btn btn-back">
        <i class="bi bi-arrow-right"></i> رجوع
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger mb-3">
        @foreach($errors->all() as $error)
            <p class="mb-0">{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="section-title">معلومات الدور</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">اسم الدور *</label>
                    <input type="text" name="name" class="form-control" placeholder="مثال: hr_manager" required>
                    <small style="color:#9ca3af">استخدم الإنجليزية فقط بدون مسافات</small>
                </div>
            </div>

            <div class="section-title">الصلاحيات</div>
            <div class="row g-3">
                @foreach($permissions as $module => $modulePermissions)
                <div class="col-md-6">
                    <div class="card" style="background:#f9fafb; border:1px solid #e5e7eb">
                        <div class="card-body" style="padding:15px">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0" style="font-weight:600">{{ $module }}</h6>
                                <div>
                                    <input type="checkbox" onchange="toggleAll(this, '{{ $module }}')" class="form-check-input">
                                    <small>الكل</small>
                                </div>
                            </div>
                            @foreach($modulePermissions as $permission)
                            <div class="form-check mb-2">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="p_{{ $permission->id }}" class="form-check-input perm-{{ $module }}">
                                <label class="form-check-label" for="p_{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-lg"></i> حفظ
                </button>
                <a href="{{ route('roles.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleAll(checkbox, module) {
    document.querySelectorAll('.perm-' + module).forEach(function(item) {
        item.checked = checkbox.checked;
    });
}
</script>

@endsection