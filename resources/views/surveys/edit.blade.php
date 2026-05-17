@extends('layouts.app')
@section('title', 'تعديل الاستبيان')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-clipboard-data"></i> تعديل الاستبيان</h4>
    <a href="{{ route('surveys.show', $survey->id) }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('surveys.update', $survey->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">العنوان *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $survey->title) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">الحالة *</label>
                    <select name="status" class="form-select" required>
                        <option value="draft"  {{ old('status',$survey->status)=='draft'  ?'selected':'' }}>مسودة</option>
                        <option value="active" {{ old('status',$survey->status)=='active' ?'selected':'' }}>نشط</option>
                        <option value="closed" {{ old('status',$survey->status)=='closed' ?'selected':'' }}>مغلق</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $survey->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">تاريخ البداية</label>
                    <input type="date" name="starts_at" class="form-control" value="{{ old('starts_at', $survey->starts_at?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">تاريخ الانتهاء</label>
                    <input type="date" name="ends_at" class="form-control" value="{{ old('ends_at', $survey->ends_at?->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save"><i class="bi bi-save"></i> حفظ التعديلات</button>
                <a href="{{ route('surveys.show', $survey->id) }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
