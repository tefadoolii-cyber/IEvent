@extends('layouts.app')
@section('title', 'تعديل حدث')
@section('content')

<div class="top-header">
    <h4>تعديل الحدث — {{ $event->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('events.show', $event->id) }}" class="btn btn-edit"><i class="bi bi-eye"></i> عرض</a>
        <a href="{{ route('events.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach
</div>
@endif

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="{{ route('events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="section-title">بيانات الحدث</div>
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <label class="form-label">اسم الحدث *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">نوع الحدث</label>
                    @if($eventTypes->count())
                    <select name="type" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($eventTypes as $t)
                            <option value="{{ $t->value_ar }}" {{ old('type',$event->type)==$t->value_ar ? 'selected':'' }}>{{ $t->value_ar }}</option>
                        @endforeach
                    </select>
                    @else
                    <input type="text" name="type" class="form-control" value="{{ old('type', $event->type) }}">
                    @endif
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ البدء *</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $event->start_date?->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ الانتهاء</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $event->end_date?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">الموقع</label>
                    <select name="location_id" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id',$event->location_id)==$loc->id ? 'selected':'' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="planning" {{ old('status',$event->status)=='planning'  ? 'selected':'' }}>تخطيط</option>
                        <option value="active"   {{ old('status',$event->status)=='active'    ? 'selected':'' }}>نشط</option>
                        <option value="completed"{{ old('status',$event->status)=='completed' ? 'selected':'' }}>مكتمل</option>
                        <option value="cancelled"{{ old('status',$event->status)=='cancelled' ? 'selected':'' }}>ملغي</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">مدير الحدث</label>
                    <select name="manager_id" class="form-select">
                        <option value="">-- اختر --</option>
                        @foreach($managers as $m)
                            <option value="{{ $m->id }}" {{ old('manager_id',$event->manager_id)==$m->id ? 'selected':'' }}>{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الميزانية (ر.س)</label>
                    <input type="number" name="budget" class="form-control" value="{{ old('budget', $event->budget) }}" min="0" step="0.01">
                </div>
                <div class="col-12">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $event->description) }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ التعديل</button>
                <a href="{{ route('events.index') }}" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>

@endsection
