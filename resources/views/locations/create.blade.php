@extends('layouts.app')
@section('title', 'إضافة موقع')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-geo-alt"></i> إضافة موقع جديد</h4>
    <a href="{{ route('locations.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card"><div class="card-body" style="padding:25px">
    <form action="{{ route('locations.store') }}" method="POST">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">اسم الموقع *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">المنطقة</label>
                <select name="region_id" class="form-select" id="regionSelect" onchange="loadChildren(this.value)">
                    <option value="">-- بدون منطقة --</option>
                    @foreach($regions->whereNull('parent_id') as $region)
                        <option value="{{ $region->id }}" {{ old('region_id')==$region->id?'selected':'' }}>{{ $region->name }}</option>
                        @foreach($regions->where('parent_id', $region->id) as $child)
                            <option value="{{ $child->id }}" {{ old('region_id')==$child->id?'selected':'' }}>&nbsp;&nbsp;&nbsp;↳ {{ $child->name }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">النوع</label>
                <input type="text" name="type" class="form-control" value="{{ old('type') }}" placeholder="مثال: مخيم، فندق، قاعة">
            </div>
            <div class="col-md-4">
                <label class="form-label">المدينة</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">السعة</label>
                <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ old('is_active','1')=='1'?'selected':'' }}>نشط</option>
                    <option value="0" {{ old('is_active')=='0'?'selected':'' }}>غير نشط</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">خط العرض (lat)</label>
                <input type="number" step="any" name="lat" class="form-control" value="{{ old('lat') }}" id="lat">
            </div>
            <div class="col-md-4">
                <label class="form-label">خط الطول (lng)</label>
                <input type="number" step="any" name="lng" class="form-control" value="{{ old('lng') }}" id="lng">
            </div>
            <div class="col-12">
                <label class="form-label">العنوان</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
            <a href="{{ route('locations.index') }}" class="btn btn-back">إلغاء</a>
        </div>
    </form>
</div></div>
@endsection
