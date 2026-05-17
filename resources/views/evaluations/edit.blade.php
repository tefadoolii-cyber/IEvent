@extends('layouts.app')
@section('title', 'تعديل تقييم')
@section('content')

<div class="top-header">
    <h4>تعديل التقييم</h4>
    <a href="{{ route('evaluations.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('evaluations.update', $evaluation->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">الموظف *</label>
                    <select name="employee_id" class="form-select" required>
                        <option value="">-- اختر --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id',$evaluation->employee_id)==$emp->id?'selected':'' }}>{{ $emp->name }} — {{ $emp->department ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الفترة *</label>
                    <input type="text" name="period" class="form-control" value="{{ old('period', $evaluation->period) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="draft"     {{ old('status',$evaluation->status)=='draft'     ?'selected':'' }}>مسودة</option>
                        <option value="submitted" {{ old('status',$evaluation->status)=='submitted' ?'selected':'' }}>مُقدَّم</option>
                        <option value="approved"  {{ old('status',$evaluation->status)=='approved'  ?'selected':'' }}>معتمد</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">الدرجة الإجمالية (0-100) *</label>
                    <input type="number" name="total_score" class="form-control" value="{{ old('total_score', $evaluation->total_score) }}" min="0" max="100" required>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $evaluation->notes) }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ التعديل</button>
                <a href="{{ route('evaluations.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
