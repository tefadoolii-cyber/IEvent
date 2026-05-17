@extends('layouts.app')
@section('title', 'تفاصيل التقييم')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-star"></i> تقييم {{ $evaluation->employee->name }} — {{ $evaluation->period }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('evaluations.edit', $evaluation->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i> تعديل</a>
        <a href="{{ route('evaluations.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-info-circle"></i> ملخص التقييم</span></div>
            <div class="card-body" style="padding:20px;text-align:center">
                <div style="width:100px;height:100px;border-radius:50%;background:linear-gradient(135deg,#1a1a2e,#0f3460);display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px">
                    <div>
                        <div style="font-size:28px;font-weight:900;color:white">{{ $evaluation->total_score }}</div>
                        <div style="font-size:11px;color:rgba(255,255,255,0.7)">/ 100</div>
                    </div>
                </div>
                <div style="font-weight:700;font-size:16px;color:#1a1a2e">{{ $evaluation->employee->name }}</div>
                <div style="font-size:12px;color:#9ca3af;margin-top:2px">{{ $evaluation->employee->department }}</div>
                @php $sc=['draft'=>'#d97706','submitted'=>'#2563eb','approved'=>'#16a34a'];$sb=['draft'=>'#fef3c7','submitted'=>'#dbeafe','approved'=>'#dcfce7']; @endphp
                <div style="margin-top:10px">
                    <span style="background:{{ $sb[$evaluation->status]??'#f3f4f6' }};color:{{ $sc[$evaluation->status]??'#6b7280' }};padding:4px 14px;border-radius:20px;font-size:12px;font-weight:600">
                        {{ $evaluation->status_label }}
                    </span>
                </div>

                @foreach([
                    ['icon'=>'bi-calendar','label'=>'الفترة',      'value'=>$evaluation->period],
                    ['icon'=>'bi-person',  'label'=>'المُقيِّم',   'value'=>$evaluation->evaluator->name],
                    ['icon'=>'bi-clock',   'label'=>'التاريخ',      'value'=>$evaluation->created_at->format('Y-m-d')],
                ] as $r)
                <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px;text-align:right">
                    <i class="bi {{ $r['icon'] }}" style="color:#9ca3af;width:16px"></i>
                    <span style="color:#6b7280;flex:1">{{ $r['label'] }}</span>
                    <span style="font-weight:600">{{ $r['value'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-8">
        @if($evaluation->criteria && count($evaluation->criteria))
        <div class="card mb-3">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-list-check"></i> تفاصيل المعايير</span></div>
            <div class="card-body" style="padding:20px">
                @foreach($evaluation->criteria as $cr)
                @php $score = $cr['score'] ?? 0; @endphp
                <div style="margin-bottom:14px">
                    <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px">
                        <span style="font-weight:600">{{ $cr['label'] ?? 'معيار' }}</span>
                        <span style="font-weight:700;color:{{ $score>=80?'#16a34a':($score>=60?'#d97706':'#dc2626') }}">{{ $score }}/100</span>
                    </div>
                    <div style="background:#f3f4f6;border-radius:8px;height:8px;overflow:hidden">
                        <div style="width:{{ $score }}%;height:100%;background:{{ $score>=80?'#16a34a':($score>=60?'#d97706':'#dc2626') }};border-radius:8px;transition:width 0.5s"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($evaluation->notes)
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-chat-text"></i> الملاحظات</span></div>
            <div class="card-body" style="padding:16px;font-size:13px;line-height:1.7;color:#374151">{{ $evaluation->notes }}</div>
        </div>
        @endif
    </div>
</div>
@endsection
