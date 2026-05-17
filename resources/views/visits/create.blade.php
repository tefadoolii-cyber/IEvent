@extends('layouts.app')
@section('title', 'تسجيل زيارة')
@section('content')

<div class="top-header">
    <h4>تسجيل زيارة جديدة</h4>
    <a href="{{ route('visits.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('visits.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">الموظف *</label>
                    <select name="employee_id" class="form-select" required>
                        <option value="">-- اختر --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id')==$emp->id?'selected':'' }}>{{ $emp->name }} — {{ $emp->employee_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الموقع</label>
                    <select name="location_id" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id')==$loc->id?'selected':'' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">تاريخ الزيارة *</label>
                    <input type="date" name="visit_date" class="form-control" value="{{ old('visit_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">وقت الحضور</label>
                    <input type="time" name="check_in_time" class="form-control" value="{{ old('check_in_time') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">وقت الانصراف</label>
                    <input type="time" name="check_out_time" class="form-control" value="{{ old('check_out_time') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="pending"   {{ old('status','pending')=='pending'   ?'selected':'' }}>معلق</option>
                        <option value="completed" {{ old('status')=='completed' ?'selected':'' }}>مكتمل</option>
                        <option value="cancelled" {{ old('status')=='cancelled' ?'selected':'' }}>ملغي</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                <a href="{{ route('visits.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
