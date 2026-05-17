@extends('employee.layout')
@section('title', 'عهدتي')
@section('content')

<div class="welcome">
    <h2><i class="bi bi-laptop"></i> عهدتي</h2>
    <p>الأجهزة والمعدات المسلَّمة لك</p>
</div>

@if(!$employee)
    <div class="card"><div class="alert alert-warning mb-0">حسابك غير مربوط بملف موظف.</div></div>
@elseif($assignments->where('returned_at', null)->isEmpty())
    <div class="card" style="text-align:center;padding:40px;color:#9ca3af">
        <i class="bi bi-laptop" style="font-size:40px"></i>
        <p class="mt-3">لا توجد أجهزة مسلَّمة لك حالياً</p>
    </div>
@else
    <div style="margin-bottom:20px">
        <div style="font-weight:700;font-size:15px;color:#1a1a2e;margin-bottom:12px">الأجهزة الحالية</div>
        <div class="row g-3">
            @foreach($assignments->where('returned_at', null) as $asgn)
            <div class="col-md-6">
                <div class="card">
                    <div style="display:flex;align-items:center;gap:15px">
                        <div style="width:50px;height:50px;background:#1a1a2e;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#4ade80;font-size:22px;flex-shrink:0">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <div>
                            <div style="font-weight:700">{{ $asgn->asset->name }}</div>
                            <div style="color:#9ca3af;font-size:12px">{{ $asgn->asset->type }} {{ $asgn->asset->brand ? '· '.$asgn->asset->brand : '' }}</div>
                            @if($asgn->asset->serial_number)
                            <div style="font-family:monospace;font-size:11px;color:#6b7280">S/N: {{ $asgn->asset->serial_number }}</div>
                            @endif
                        </div>
                    </div>
                    <hr style="margin:12px 0">
                    <div style="font-size:12px;color:#6b7280">
                        <i class="bi bi-calendar"></i> تاريخ الاستلام: <strong>{{ $asgn->delivered_at?->format('Y-m-d') ?? '-' }}</strong>
                    </div>
                    @if($asgn->notes)
                    <div style="font-size:12px;color:#6b7280;margin-top:4px">{{ $asgn->notes }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($assignments->where('returned_at', '!=', null)->isNotEmpty())
    <div>
        <div style="font-weight:700;font-size:15px;color:#1a1a2e;margin-bottom:12px">سجل المُعادة</div>
        <div class="card">
            @foreach($assignments->where('returned_at', '!=', null) as $asgn)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                <div>
                    <div style="font-weight:600">{{ $asgn->asset->name }}</div>
                    <div style="color:#9ca3af;font-size:11px">{{ $asgn->asset->type }}</div>
                </div>
                <div style="text-align:left;color:#6b7280">
                    <div>استُلم: {{ $asgn->delivered_at?->format('Y-m-d') ?? '-' }}</div>
                    <div>أُعيد: {{ $asgn->returned_at?->format('Y-m-d') }}</div>
                </div>
                <span style="background:#f3f4f6;color:#6b7280;padding:3px 9px;border-radius:20px;font-size:11px">مُعاد</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@endif
@endsection
