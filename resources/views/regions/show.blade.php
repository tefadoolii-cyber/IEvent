@extends('layouts.app')
@section('title', 'تفاصيل المنطقة')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-map"></i> منطقة — {{ $region->name }}</h4>
    <a href="{{ route('regions.index') }}" class="btn btn-back">رجوع</a>
</div>

<div class="row g-3">
    {{-- بيانات المنطقة --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><span style="font-weight:600">بيانات المنطقة</span></div>
            <div class="card-body" style="padding:20px;font-size:13px">
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f0f0">
                    <span style="color:#6b7280">المنطقة الأم</span>
                    <strong>{{ $region->parent?->name ?? '—' }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f0f0">
                    <span style="color:#6b7280">الحالة</span>
                    <span style="background:{{ $region->is_active?'#dcfce7':'#fee2e2' }};color:{{ $region->is_active?'#16a34a':'#dc2626' }};padding:2px 10px;border-radius:20px;font-size:11px;font-weight:600">
                        {{ $region->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f0f0">
                    <span style="color:#6b7280">عدد المواقع</span>
                    <strong style="color:#1d4ed8">{{ $region->locations->count() }}</strong>
                </div>
                @if($region->children->count())
                <div style="padding:8px 0">
                    <span style="color:#6b7280;display:block;margin-bottom:6px">المناطق الفرعية</span>
                    <div style="display:flex;flex-wrap:wrap;gap:4px">
                        @foreach($region->children as $child)
                        <span style="background:#eff6ff;color:#1d4ed8;padding:2px 8px;border-radius:10px;font-size:11px">{{ $child->name }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                @if($region->notes)
                <div style="margin-top:12px;padding:10px;background:#f9fafb;border-radius:8px;color:#374151">{{ $region->notes }}</div>
                @endif
            </div>
        </div>
    </div>

    {{-- المواقع التابعة --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span style="font-weight:600">المواقع التابعة ({{ $region->locations->count() }})</span>
                <a href="{{ route('locations.create') }}" class="btn btn-add" style="font-size:12px;padding:4px 12px"><i class="bi bi-plus-lg"></i> إضافة موقع</a>
            </div>
            <div class="card-body p-0">
                @if($region->locations->count())
                <div class="table-responsive">
                <table class="table mb-0" style="font-size:13px">
                    <thead>
                        <tr><th>الموقع</th><th>النوع</th><th>المدينة</th><th>السعة</th><th>الحالة</th><th></th></tr>
                    </thead>
                    <tbody>
                        @foreach($region->locations as $loc)
                        <tr>
                            <td>
                                <div style="font-weight:600">{{ $loc->name }}</div>
                                @if($loc->address)<div style="font-size:11px;color:#9ca3af">{{ Str::limit($loc->address,40) }}</div>@endif
                            </td>
                            <td>{{ $loc->type ?? '—' }}</td>
                            <td>{{ $loc->city ?? '—' }}</td>
                            <td>{{ $loc->capacity ? number_format($loc->capacity) : '—' }}</td>
                            <td>
                                @if($loc->is_active)
                                    <span class="badge-active" style="font-size:11px">نشط</span>
                                @else
                                    <span class="badge-inactive" style="font-size:11px">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:4px">
                                    <a href="{{ route('locations.show', $loc->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('locations.edit', $loc->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                                    @if($loc->lat && $loc->lng)
                                    <a href="{{ $loc->maps_url }}" target="_blank" class="btn btn-save" style="font-size:11px;padding:4px 8px;background:#1d4ed8;color:white"><i class="bi bi-pin-map"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                @else
                <div class="text-center py-5" style="color:#9ca3af">
                    <i class="bi bi-geo-alt" style="font-size:36px"></i>
                    <p class="mt-2 mb-0">لا توجد مواقع في هذه المنطقة</p>
                    <a href="{{ route('locations.create') }}" class="btn btn-save mt-3" style="font-size:13px">إضافة موقع</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
