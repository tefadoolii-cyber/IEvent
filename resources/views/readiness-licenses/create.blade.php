@extends('layouts.app')
@section('title', 'إصدار رخصة جاهزية')
@section('content')

<div class="top-header">
    <h4>إصدار رخصة جاهزية</h4>
    <a href="{{ route('readiness-licenses.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('readiness-licenses.store') }}" method="POST">
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
                <div class="col-md-3">
                    <label class="form-label">تاريخ الإصدار *</label>
                    <input type="date" name="issued_at" class="form-control" value="{{ old('issued_at', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ الانتهاء</label>
                    <input type="date" name="expires_at" class="form-control" value="{{ old('expires_at') }}">
                    <div style="font-size:11px;color:#9ca3af;margin-top:3px">اتركه فارغاً للرخصة الدائمة</div>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save"><i class="bi bi-shield-check"></i> إصدار الرخصة</button>
                <a href="{{ route('readiness-licenses.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
