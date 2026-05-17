@extends('layouts.app')
@section('title', 'استبيان جديد')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-clipboard-data"></i> إنشاء استبيان جديد</h4>
    <a href="{{ route('surveys.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<form action="{{ route('surveys.store') }}" method="POST">
@csrf
<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><span style="font-weight:600">بيانات الاستبيان</span></div>
            <div class="card-body" style="padding:20px">
                <div class="mb-3">
                    <label class="form-label">العنوان *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">الحالة *</label>
                        <select name="status" class="form-select" required>
                            <option value="draft"  {{ old('status','draft')=='draft'  ?'selected':'' }}>مسودة</option>
                            <option value="active" {{ old('status')=='active' ?'selected':'' }}>نشط</option>
                            <option value="closed" {{ old('status')=='closed' ?'selected':'' }}>مغلق</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ البداية</label>
                        <input type="date" name="starts_at" class="form-control" value="{{ old('starts_at') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ الانتهاء</label>
                        <input type="date" name="ends_at" class="form-control" value="{{ old('ends_at') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" style="background:#f9fafb;border:2px dashed #e5e7eb">
            <div class="card-body" style="padding:16px;font-size:13px;color:#6b7280">
                <i class="bi bi-info-circle" style="color:#3b82f6"></i>
                <strong> ملاحظة:</strong> يمكنك إضافة الأسئلة بعد حفظ الاستبيان من صفحة التفاصيل.
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-save"><i class="bi bi-save"></i> حفظ الاستبيان</button>
    <a href="{{ route('surveys.index') }}" class="btn btn-back">إلغاء</a>
</div>
</form>
@endsection
