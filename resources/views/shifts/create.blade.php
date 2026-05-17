@extends('layouts.app')
@section('title', 'إضافة وردية')
@section('content')

<div class="top-header">
    <h4>إضافة وردية جديدة</h4>
    <a href="{{ route('shifts.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('shifts.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">اسم الوردية *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="مثال: الوردية الصباحية">
                </div>
                <div class="col-md-3">
                    <label class="form-label">وقت البدء *</label>
                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">وقت الانتهاء *</label>
                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">أيام العمل</label>
                    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:6px">
                        @php
                            $dayLabels = ['sat'=>'السبت','sun'=>'الأحد','mon'=>'الاثنين','tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس','fri'=>'الجمعة'];
                            $oldDays = old('days', []);
                        @endphp
                        @foreach($dayLabels as $val => $label)
                        <label style="display:flex;align-items:center;gap:6px;cursor:pointer;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:8px 14px;font-size:13px">
                            <input type="checkbox" name="days[]" value="{{ $val }}" {{ in_array($val, $oldDays) ? 'checked' : '' }}>
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                <a href="{{ route('shifts.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
