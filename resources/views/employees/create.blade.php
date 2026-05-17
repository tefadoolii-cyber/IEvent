@extends('layouts.app')

@section('title', 'إضافة موظف')

@section('content')

<div class="top-header">
    <h4>إضافة موظف جديد</h4>
    <a href="{{ route('employees.index') }}" class="btn btn-back">رجوع</a>
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
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- صورة شخصية --}}
            <div class="section-title">الصورة الشخصية والسيرة الذاتية</div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">الصورة الشخصية</label>
                    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
                        <div id="photo-preview" style="width:80px;height:80px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;border:2px solid #e5e7eb">
                            <i class="bi bi-person" style="font-size:36px;color:#9ca3af"></i>
                        </div>
                        <div>
                            <input type="file" name="photo" id="photo-input" class="form-control" accept="image/jpg,image/jpeg,image/png" style="font-size:13px">
                            <div style="color:#9ca3af;font-size:11px;margin-top:4px">JPG/PNG — الحد الأقصى 2MB</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">السيرة الذاتية (CV)</label>
                    <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx">
                    <div style="color:#9ca3af;font-size:11px;margin-top:4px">PDF / DOC / DOCX — الحد الأقصى 5MB</div>
                </div>
            </div>

            <div class="section-title">البيانات الأساسية</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">الاسم *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">رقم الهوية *</label>
                    <input type="text" name="employee_number" class="form-control" value="{{ old('employee_number') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">رقم الجوال</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الإيميل</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">القسم</label>
                    <select name="department" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->value_ar }}" {{ old('department') == $dept->value_ar ? 'selected' : '' }}>{{ $dept->value_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المسمى الوظيفي</label>
                    <select name="position" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($jobTitles as $job)
                            <option value="{{ $job->value_ar }}" {{ old('position') == $job->value_ar ? 'selected' : '' }}>{{ $job->value_ar }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="section-title">بيانات العقد</div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">تاريخ المباشرة</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">تاريخ فسخ العقد</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">حالة العقد</label>
                    <select name="contract_status" class="form-select">
                        <option value="active">ساري</option>
                        <option value="inactive">منتهي</option>
                        <option value="pending">معلق</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">حالة الموظف</label>
                    <select name="status" class="form-select">
                        <option value="active">نشط</option>
                        <option value="inactive">غير نشط</option>
                    </select>
                </div>
            </div>

            {{-- الحقول المخصصة --}}
            @if(count($customFields) > 0)
            <div class="section-title">حقول إضافية</div>
            <div class="row g-3 mb-4">
                @foreach($customFields as $field)
                <div class="col-md-6">
                    <label class="form-label">
                        {{ $field->field_label }}
                        @if($field->is_required) * @endif
                    </label>

                    @if($field->field_type == 'textarea')
                        <textarea name="custom_fields[{{ $field->id }}]" class="form-control" rows="3" @if($field->is_required) required @endif></textarea>
                    @elseif($field->field_type == 'select')
                        <select name="custom_fields[{{ $field->id }}]" class="form-select" @if($field->is_required) required @endif>
                            <option value="">-- اختر --</option>
                            @foreach(explode(',', $field->options) as $option)
                                <option value="{{ trim($option) }}">{{ trim($option) }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="{{ $field->field_type }}" name="custom_fields[{{ $field->id }}]" class="form-control" @if($field->is_required) required @endif>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            <div class="d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                <a href="{{ route('employees.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>

<script>
document.getElementById('photo-input').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const prev = document.getElementById('photo-preview');
        prev.innerHTML = `<img src="${e.target.result}" style="width:80px;height:80px;object-fit:cover;border-radius:50%">`;
    };
    reader.readAsDataURL(file);
});
</script>
    </div>
</div>

@endsection