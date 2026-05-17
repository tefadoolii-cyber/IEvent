@extends('layouts.app')
@section('title', 'إضافة جهاز')
@section('content')

<div class="top-header">
    <h4>إضافة جهاز جديد</h4>
    <a href="{{ route('assets.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card"><div class="card-body" style="padding:25px">
    <form action="{{ route('assets.store') }}" method="POST">
        @csrf
        <div class="section-title">بيانات الجهاز</div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">اسم الجهاز *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="مثال: لابتوب Dell">
            </div>
            <div class="col-md-6">
                <label class="form-label">النوع</label>
                <input type="text" name="type" class="form-control" value="{{ old('type') }}" placeholder="مثال: لابتوب، جوال، طابعة">
            </div>
            <div class="col-md-4">
                <label class="form-label">الماركة</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="مثال: Dell, HP, Samsung">
            </div>
            <div class="col-md-4">
                <label class="form-label">الموديل</label>
                <input type="text" name="model" class="form-control" value="{{ old('model') }}" placeholder="مثال: Latitude 5520">
            </div>
            <div class="col-md-4">
                <label class="form-label">الرقم التسلسلي</label>
                <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة *</label>
                <select name="status" class="form-select" required>
                    @foreach(['available'=>'متاح','maintenance'=>'صيانة','retired'=>'مُهلَك'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('status','available')==$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ الشراء</label>
                <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">سعر الشراء (ر.س)</label>
                <input type="number" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}" min="0" step="0.01">
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
        <a href="{{ route('assets.index') }}" class="btn btn-back">إلغاء</a>
    </form>
</div></div>
@endsection
