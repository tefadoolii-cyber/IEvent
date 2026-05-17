@extends('employee.layout')
@section('title', 'عقودي')
@section('content')

<div class="welcome">
    <h2><i class="bi bi-file-earmark-text"></i> عقودي</h2>
    <p>عرض وتوقيع عقودك الوظيفية</p>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(!$employee)
    <div class="card"><div class="alert alert-warning mb-0">حسابك غير مربوط بملف موظف. راجع الإدارة.</div></div>
@elseif($contracts->isEmpty())
    <div class="card" style="text-align:center;padding:40px;color:#9ca3af">
        <i class="bi bi-file-earmark-x" style="font-size:40px"></i>
        <p class="mt-3">لا توجد عقود مرتبطة بحسابك</p>
    </div>
@else
    @foreach($contracts as $contract)
    @php
        $colors = ['draft'=>'#6b7280','sent'=>'#d97706','signed'=>'#16a34a','cancelled'=>'#dc2626'];
        $bgs    = ['draft'=>'#f3f4f6','sent'=>'#fef3c7','signed'=>'#dcfce7','cancelled'=>'#fee2e2'];
    @endphp
    <div class="card" style="margin-bottom:20px">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:15px;flex-wrap:wrap;gap:10px">
            <div>
                <div style="font-weight:700;font-size:16px;font-family:monospace">{{ $contract->contract_number }}</div>
                <div style="color:#6b7280;font-size:13px;margin-top:4px">{{ $contract->position ?? '' }}</div>
            </div>
            <span style="background:{{ $bgs[$contract->status]??'#f3f4f6' }};color:{{ $colors[$contract->status]??'#6b7280' }};padding:5px 14px;border-radius:20px;font-size:13px;font-weight:600">
                {{ $contract->status_label }}
            </span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:15px">
            @foreach(['تاريخ البداية'=>$contract->start_date?->format('Y-m-d'),'تاريخ النهاية'=>$contract->end_date?->format('Y-m-d')??'مفتوح','الراتب'=>$contract->salary?number_format($contract->salary,0).' ر.س':'-','تاريخ التوقيع'=>$contract->signed_at?->format('Y-m-d')??'-'] as $l=>$v)
            <div>
                <div style="color:#9ca3af;font-size:12px">{{ $l }}</div>
                <div style="font-weight:600;font-size:14px">{{ $v }}</div>
            </div>
            @endforeach
        </div>

        @if($contract->terms)
        <div style="background:#f9fafb;padding:12px;border-radius:8px;font-size:13px;line-height:1.8;margin-bottom:15px;white-space:pre-line">{{ Str::limit($contract->terms, 300) }}</div>
        @endif

        {{-- ملف PDF --}}
        @if($contract->pdf_file)
        <div style="margin-bottom:15px">
            <div style="font-weight:600;font-size:13px;margin-bottom:8px"><i class="bi bi-file-pdf" style="color:#dc2626"></i> ملف العقد</div>
            <div style="border:1px solid #e5e7eb;border-radius:10px;overflow:hidden">
                <iframe src="{{ Storage::disk('public')->url($contract->pdf_file) }}" style="width:100%;height:400px;border:none;display:block"></iframe>
            </div>
            <a href="{{ Storage::disk('public')->url($contract->pdf_file) }}" download class="btn-action" style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;font-size:13px;padding:7px 16px;text-decoration:none">
                <i class="bi bi-download"></i> تحميل العقد
            </a>
        </div>
        @endif

        {{-- لوحة التوقيع --}}
        @if($contract->status === 'sent')
        <hr style="margin:15px 0">
        <div style="font-weight:600;margin-bottom:10px"><i class="bi bi-pen"></i> وقّع عقدك</div>
        <form action="{{ route('portal.contracts.sign', $contract->id) }}" method="POST" id="signForm{{ $contract->id }}">
            @csrf
            <input type="hidden" name="signature" id="sig{{ $contract->id }}">
            <div style="border:2px solid #e5e7eb;border-radius:10px;background:white;cursor:crosshair;touch-action:none;position:relative" id="wrap{{ $contract->id }}">
                <canvas id="canvas{{ $contract->id }}" width="700" height="150" style="width:100%;height:150px;display:block;border-radius:8px"></canvas>
                <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:#d1d5db;font-size:13px;pointer-events:none" id="hint{{ $contract->id }}">
                    <i class="bi bi-pen"></i> وقّع هنا
                </div>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button type="button" onclick="clearCanvas('{{ $contract->id }}')" style="background:#f3f4f6;color:#374151;border:none;border-radius:8px;padding:8px 16px;font-size:13px;cursor:pointer">مسح</button>
                <button type="button" onclick="submitSign('{{ $contract->id }}')" class="btn-action" style="font-size:14px;padding:8px 20px">
                    <i class="bi bi-check-lg"></i> توقيع وإرسال
                </button>
            </div>
        </form>
        @elseif($contract->signature)
        <hr style="margin:15px 0">
        <div style="font-size:13px;color:#6b7280;margin-bottom:8px"><i class="bi bi-check-circle" style="color:#16a34a"></i> تم التوقيع بتاريخ {{ $contract->signed_at?->format('Y-m-d H:i') }}</div>
        <div style="border:1px solid #e5e7eb;border-radius:8px;background:#fafafa;padding:8px;display:inline-block">
            <img src="{{ $contract->signature }}" style="max-height:80px;display:block">
        </div>
        @endif
    </div>
    @endforeach
@endif

<script>
const canvases = {};
function initCanvas(id) {
    const canvas = document.getElementById('canvas' + id);
    if (!canvas || canvases[id]) return;
    canvases[id] = { drawing: false };
    const ctx = canvas.getContext('2d');
    ctx.strokeStyle = '#1a1a2e';
    ctx.lineWidth = 2.5;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        if (e.touches) return { x: (e.touches[0].clientX - rect.left) * scaleX, y: (e.touches[0].clientY - rect.top) * scaleY };
        return { x: (e.clientX - rect.left) * scaleX, y: (e.clientY - rect.top) * scaleY };
    }

    canvas.addEventListener('mousedown', e => { e.preventDefault(); canvases[id].drawing = true; const p = getPos(e); ctx.beginPath(); ctx.moveTo(p.x, p.y); document.getElementById('hint'+id).style.display='none'; });
    canvas.addEventListener('mousemove', e => { if (!canvases[id].drawing) return; const p = getPos(e); ctx.lineTo(p.x, p.y); ctx.stroke(); });
    canvas.addEventListener('mouseup', () => canvases[id].drawing = false);
    canvas.addEventListener('mouseleave', () => canvases[id].drawing = false);
    canvas.addEventListener('touchstart', e => { e.preventDefault(); canvases[id].drawing = true; const p = getPos(e); ctx.beginPath(); ctx.moveTo(p.x, p.y); document.getElementById('hint'+id).style.display='none'; }, {passive:false});
    canvas.addEventListener('touchmove', e => { if (!canvases[id].drawing) return; e.preventDefault(); const p = getPos(e); ctx.lineTo(p.x, p.y); ctx.stroke(); }, {passive:false});
    canvas.addEventListener('touchend', () => canvases[id].drawing = false);
}
function clearCanvas(id) {
    const canvas = document.getElementById('canvas' + id);
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('hint'+id).style.display = 'block';
}
function submitSign(id) {
    const canvas = document.getElementById('canvas' + id);
    const blank = document.createElement('canvas');
    blank.width = canvas.width; blank.height = canvas.height;
    if (canvas.toDataURL() === blank.toDataURL()) { alert('يرجى رسم توقيعك أولاً'); return; }
    document.getElementById('sig'+id).value = canvas.toDataURL();
    document.getElementById('signForm'+id).submit();
}
document.addEventListener('DOMContentLoaded', () => {
    @foreach($contracts as $contract)
    @if($contract->status === 'sent')
    initCanvas('{{ $contract->id }}');
    @endif
    @endforeach
});
</script>
@endsection
