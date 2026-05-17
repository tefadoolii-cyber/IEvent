@extends('layouts.app')
@section('title', 'تفاصيل الزيارة')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-geo-alt"></i> تفاصيل الزيارة</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('visits.edit', $visit->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i> تعديل</a>
        <a href="{{ route('visits.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@php
    $sColors = ['pending'=>'#d97706','completed'=>'#16a34a','cancelled'=>'#dc2626'];
    $sBgs    = ['pending'=>'#fef3c7','completed'=>'#dcfce7','cancelled'=>'#fee2e2'];
@endphp

<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-info-circle"></i> بيانات الزيارة</span></div>
            <div class="card-body" style="padding:20px">
                @foreach([
                    ['icon'=>'bi-person',       'label'=>'الموظف',         'value'=>$visit->employee->name],
                    ['icon'=>'bi-credit-card-2-front','label'=>'رقم الهوية','value'=>$visit->employee->employee_number],
                    ['icon'=>'bi-geo-alt',      'label'=>'الموقع',         'value'=>$visit->location?->name],
                    ['icon'=>'bi-calendar',     'label'=>'تاريخ الزيارة', 'value'=>$visit->visit_date->format('Y-m-d')],
                    ['icon'=>'bi-clock',        'label'=>'وقت الحضور',     'value'=>$visit->check_in_time],
                    ['icon'=>'bi-clock-history','label'=>'وقت الانصراف',  'value'=>$visit->check_out_time],
                ] as $row)
                <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <i class="bi {{ $row['icon'] }}" style="color:#9ca3af;width:16px;flex-shrink:0"></i>
                    <span style="color:#6b7280;flex:1">{{ $row['label'] }}</span>
                    <span style="font-weight:600">{{ $row['value'] ?? '-' }}</span>
                </div>
                @endforeach

                <div style="margin-top:14px;text-align:center">
                    <span style="background:{{ $sBgs[$visit->status]??'#f3f4f6' }};color:{{ $sColors[$visit->status]??'#6b7280' }};padding:6px 18px;border-radius:20px;font-size:13px;font-weight:700">
                        {{ $visit->status_label }}
                    </span>
                </div>

                @if($visit->notes)
                <div style="margin-top:14px;padding:12px;background:#f9fafb;border-radius:8px;font-size:13px;color:#374151;line-height:1.6">
                    <strong>ملاحظات:</strong><br>{{ $visit->notes }}
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($visit->lat && $visit->lng)
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-map"></i> موقع الزيارة</span></div>
            <div class="card-body" style="padding:0">
                <div style="font-size:12px;color:#6b7280;padding:10px 16px;background:#f9fafb;border-bottom:1px solid #e5e7eb">
                    <i class="bi bi-pin-map"></i>
                    الإحداثيات: {{ $visit->lat }}, {{ $visit->lng }}
                </div>
                <div id="map" style="height:300px;width:100%"></div>
            </div>
        </div>
    </div>
    @endif
</div>

@if($visit->lat && $visit->lng)
<script>
    function initMap() {
        const pos = { lat: {{ $visit->lat }}, lng: {{ $visit->lng }} };
        const map = new google.maps.Map(document.getElementById('map'), { zoom: 15, center: pos });
        new google.maps.Marker({ position: pos, map });
    }
</script>
@endif
@endsection
