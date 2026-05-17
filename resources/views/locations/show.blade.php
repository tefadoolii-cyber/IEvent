@extends('layouts.app')
@section('title', 'تفاصيل الموقع')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-geo-alt"></i> {{ $location->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i> تعديل</a>
        <a href="{{ route('locations.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><span style="font-weight:600">بيانات الموقع</span></div>
            <div class="card-body" style="padding:20px">
                @foreach([
                    ['bi-tag',       'النوع',    $location->type    ?? '—'],
                    ['bi-building',  'المدينة',  $location->city    ?? '—'],
                    ['bi-people',    'السعة',    $location->capacity ? number_format($location->capacity) : '—'],
                    ['bi-card-text', 'العنوان',  $location->address ?? '—'],
                ] as [$icon,$label,$val])
                <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <i class="bi {{ $icon }}" style="color:#9ca3af;width:16px"></i>
                    <span style="color:#6b7280;flex:1">{{ $label }}</span>
                    <span style="font-weight:600">{{ $val }}</span>
                </div>
                @endforeach

                {{-- المنطقة --}}
                <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <i class="bi bi-map" style="color:#9ca3af;width:16px"></i>
                    <span style="color:#6b7280;flex:1">المنطقة</span>
                    <span>
                        @if($location->region)
                            @if($location->region->parent)
                                <span style="font-size:11px;color:#9ca3af">{{ $location->region->parent->name }} ← </span>
                            @endif
                            <a href="{{ route('regions.index') }}" style="color:#1d4ed8;font-weight:600;text-decoration:none">{{ $location->region->name }}</a>
                        @else
                            <span style="color:#9ca3af">—</span>
                        @endif
                    </span>
                </div>

                {{-- الحالة --}}
                <div style="margin-top:14px;text-align:center">
                    @if($location->is_active)
                        <span class="badge-active" style="font-size:13px;padding:6px 18px">نشط</span>
                    @else
                        <span class="badge-inactive" style="font-size:13px;padding:6px 18px">غير نشط</span>
                    @endif
                </div>

                @if($location->notes)
                <div style="margin-top:14px;padding:12px;background:#f9fafb;border-radius:8px;font-size:13px;color:#374151">{{ $location->notes }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        {{-- الإحداثيات وخريطة Google --}}
        @if($location->lat && $location->lng)
        <div class="card mb-3">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-pin-map"></i> الموقع الجغرافي</span></div>
            <div class="card-body" style="padding:20px">
                <div style="display:flex;gap:20px;margin-bottom:16px;font-size:13px">
                    <div>
                        <span style="color:#6b7280">خط العرض:</span>
                        <strong style="font-family:monospace;margin-right:6px">{{ $location->lat }}</strong>
                    </div>
                    <div>
                        <span style="color:#6b7280">خط الطول:</span>
                        <strong style="font-family:monospace;margin-right:6px">{{ $location->lng }}</strong>
                    </div>
                </div>
                <a href="{{ $location->maps_url }}" target="_blank" class="btn btn-save w-100" style="background:#1d4ed8;color:white">
                    <i class="bi bi-google"></i> فتح في Google Maps
                </a>
            </div>
        </div>
        @endif

        {{-- مواقع أخرى في نفس المنطقة --}}
        @if($siblings->count())
        <div class="card">
            <div class="card-header"><span style="font-weight:600">مواقع أخرى في {{ $location->region?->name }}</span></div>
            <div class="card-body p-0">
                <table class="table mb-0" style="font-size:13px">
                    <tbody>
                        @foreach($siblings as $s)
                        <tr>
                            <td>
                                <a href="{{ route('locations.show', $s->id) }}" style="color:#374151;text-decoration:none;font-weight:600">{{ $s->name }}</a>
                                @if($s->city)<div style="font-size:11px;color:#9ca3af">{{ $s->city }}</div>@endif
                            </td>
                            <td style="text-align:left">
                                @if($s->is_active)<span class="badge-active" style="font-size:11px">نشط</span>@else<span class="badge-inactive" style="font-size:11px">غير نشط</span>@endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
