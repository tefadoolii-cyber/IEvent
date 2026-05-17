@extends('layouts.app')
@section('title', 'إضافة فريق')
@section('content')

<div class="top-header">
    <h4>إضافة فريق جديد</h4>
    <a href="{{ route('teams.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('teams.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">اسم الفريق *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المشرف</label>
                    <select name="supervisor_id" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('supervisor_id')==$emp->id?'selected':'' }}>{{ $emp->name }} — {{ $emp->employee_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المنطقة</label>
                    <select name="region_id" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($regions as $r)
                            <option value="{{ $r->id }}" {{ old('region_id')==$r->id?'selected':'' }}>{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الحالة</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ old('is_active','1')=='1'?'selected':'' }}>نشط</option>
                        <option value="0" {{ old('is_active')=='0'?'selected':'' }}>غير نشط</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                <a href="{{ route('teams.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
