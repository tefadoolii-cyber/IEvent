@extends('layouts.app')

@section('title', 'تفاصيل العقد')

@section('content')

<div class="top-header">
    <h4>تفاصيل العقد - {{ $contract->contract_number }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('contracts.pdf', $contract->id) }}" class="btn btn-add" target="_blank">
            <i class="bi bi-file-pdf"></i> تحميل PDF
        </a>
        <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-edit">
            <i class="bi bi-pencil"></i> تعديل
        </a>
        <a href="{{ route('contracts.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3">
    {{-- تفاصيل العقد --}}
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header"><span style="font-weight:600">بيانات العقد</span></div>
            <div class="card-body" style="padding:20px">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div style="color:#6b7280;font-size:13px;margin-bottom:4px">رقم العقد</div>
                        <div style="font-weight:700;font-family:monospace;font-size:16px">{{ $contract->contract_number }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="color:#6b7280;font-size:13px;margin-bottom:4px">الحالة</div>
                        @php
                            $colors = ['draft'=>'#6b7280','sent'=>'#d97706','signed'=>'#16a34a','cancelled'=>'#dc2626'];
                            $bgs    = ['draft'=>'#f3f4f6','sent'=>'#fef3c7','signed'=>'#dcfce7','cancelled'=>'#fee2e2'];
                        @endphp
                        <span style="background:{{ $bgs[$contract->status]??'#f3f4f6' }};color:{{ $colors[$contract->status]??'#6b7280' }};padding:5px 14px;border-radius:20px;font-size:13px;font-weight:600">
                            {{ $contract->status_label }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div style="color:#6b7280;font-size:13px;margin-bottom:4px">تاريخ البداية</div>
                        <div style="font-weight:600">{{ $contract->start_date?->format('Y-m-d') ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="color:#6b7280;font-size:13px;margin-bottom:4px">تاريخ النهاية</div>
                        <div style="font-weight:600">{{ $contract->end_date?->format('Y-m-d') ?? 'مفتوح' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="color:#6b7280;font-size:13px;margin-bottom:4px">المسمى الوظيفي</div>
                        <div style="font-weight:600">{{ $contract->position ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div style="color:#6b7280;font-size:13px;margin-bottom:4px">الراتب الشهري</div>
                        <div style="font-weight:600">{{ $contract->salary ? number_format($contract->salary, 2).' ر.س' : '-' }}</div>
                    </div>
                    @if($contract->signed_at)
                    <div class="col-md-6">
                        <div style="color:#6b7280;font-size:13px;margin-bottom:4px">تاريخ التوقيع</div>
                        <div style="font-weight:600">{{ $contract->signed_at->format('Y-m-d H:i') }}</div>
                    </div>
                    @endif
                </div>

                @if($contract->terms)
                <hr style="margin:20px 0">
                <div style="color:#6b7280;font-size:13px;margin-bottom:8px">البنود والشروط</div>
                <div style="background:#f9fafb;padding:15px;border-radius:8px;font-size:14px;line-height:1.8;white-space:pre-line">{{ $contract->terms }}</div>
                @endif
            </div>
        </div>

        {{-- ملف PDF المرفوع --}}
        @if($contract->pdf_file)
        <div class="card mb-3">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-file-pdf"></i> ملف العقد</span>
                <a href="{{ Storage::disk('public')->url($contract->pdf_file) }}" download class="btn btn-add" style="font-size:12px;padding:4px 12px">
                    <i class="bi bi-download"></i> تحميل
                </a>
            </div>
            <div class="card-body" style="padding:0">
                <iframe src="{{ Storage::disk('public')->url($contract->pdf_file) }}" style="width:100%;height:500px;border:none;border-radius:0 0 12px 12px"></iframe>
            </div>
        </div>
        @endif

        {{-- التوقيع الإلكتروني --}}
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-pen"></i> التوقيع الإلكتروني</span>
            </div>
            <div class="card-body" style="padding:20px">
                @if($contract->signature)
                    <div style="margin-bottom:15px">
                        <div style="color:#6b7280;font-size:13px;margin-bottom:8px">التوقيع الحالي ({{ $contract->signed_at?->format('Y-m-d H:i') }})</div>
                        <div style="border:1px solid #e5e7eb;border-radius:10px;background:#fafafa;padding:10px;display:inline-block">
                            <img src="{{ $contract->signature }}" style="max-height:120px;display:block">
                        </div>
                    </div>
                    <hr>
                    <div style="color:#6b7280;font-size:13px;margin-bottom:12px">تحديث التوقيع:</div>
                @else
                    <div style="color:#6b7280;font-size:13px;margin-bottom:12px">
                        @if($contract->status === 'cancelled')
                            <span style="color:#dc2626">هذا العقد ملغي ولا يمكن توقيعه</span>
                        @else
                            ارسم توقيعك في المربع أدناه ثم اضغط "حفظ التوقيع":
                        @endif
                    </div>
                @endif

                @if($contract->status !== 'cancelled')
                <form id="signForm" action="{{ route('contracts.sign', $contract->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="signature" id="signatureData">

                    <div style="position:relative;border:2px solid #e5e7eb;border-radius:10px;background:white;cursor:crosshair;touch-action:none;user-select:none" id="canvasWrapper">
                        <canvas id="signatureCanvas" width="700" height="200" style="width:100%;height:200px;display:block;border-radius:8px"></canvas>
                        <div id="canvasPlaceholder" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:#d1d5db;font-size:14px;pointer-events:none">
                            <i class="bi bi-pen" style="font-size:20px"></i><br>وقّع هنا
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="button" onclick="clearSignature()" class="btn btn-back">
                            <i class="bi bi-eraser"></i> مسح
                        </button>
                        <button type="button" onclick="saveSignature()" class="btn btn-save">
                            <i class="bi bi-check-lg"></i> حفظ التوقيع
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>

    {{-- بيانات الموظف --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-person"></i> بيانات الموظف</span></div>
            <div class="card-body" style="padding:20px">
                <div style="display:flex;align-items:center;gap:15px;margin-bottom:20px">
                    <div style="width:52px;height:52px;background:#1a1a2e;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:20px;flex-shrink:0">
                        {{ mb_substr($contract->employee->name,0,1) }}
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:15px">{{ $contract->employee->name }}</div>
                        <div style="color:#9ca3af;font-size:12px;font-family:monospace">{{ $contract->employee->employee_number }}</div>
                    </div>
                </div>
                @foreach([
                    'القسم'           => $contract->employee->department,
                    'المسمى الوظيفي' => $contract->employee->position,
                    'الجوال'          => $contract->employee->phone,
                    'البريد'          => $contract->employee->email,
                    'تاريخ المباشرة' => $contract->employee->start_date?->format('Y-m-d'),
                    'حالة الموظف'    => $contract->employee->status === 'active' ? 'نشط' : 'غير نشط',
                ] as $label => $value)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px;gap:8px">
                    <span style="color:#6b7280;white-space:nowrap">{{ $label }}</span>
                    <span style="font-weight:600;text-align:left;word-break:break-all">{{ $value ?? '-' }}</span>
                </div>
                @endforeach
                <div class="mt-3">
                    <a href="{{ route('employees.show', $contract->employee->id) }}" class="btn btn-edit w-100">
                        <i class="bi bi-person"></i> فتح ملف الموظف
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const canvas = document.getElementById('signatureCanvas');
if (canvas) {
    const ctx = canvas.getContext('2d');
    let drawing = false;
    let hasDrawn = false;

    function resizeCanvas() {
        const wrapper = document.getElementById('canvasWrapper');
        const ratio = canvas.width / wrapper.clientWidth;
        canvas.dataset.ratio = ratio;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        const ratio = parseFloat(canvas.dataset.ratio) || 1;
        if (e.touches) {
            return {
                x: (e.touches[0].clientX - rect.left) * ratio,
                y: (e.touches[0].clientY - rect.top) * (canvas.height / rect.height)
            };
        }
        return {
            x: (e.clientX - rect.left) * ratio,
            y: (e.clientY - rect.top) * (canvas.height / rect.height)
        };
    }

    ctx.strokeStyle = '#1a1a2e';
    ctx.lineWidth = 2.5;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    function startDraw(e) {
        e.preventDefault();
        drawing = true;
        const pos = getPos(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
        document.getElementById('canvasPlaceholder').style.display = 'none';
    }

    function draw(e) {
        if (!drawing) return;
        e.preventDefault();
        const pos = getPos(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        hasDrawn = true;
    }

    function stopDraw() { drawing = false; }

    canvas.addEventListener('mousedown', startDraw);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDraw);
    canvas.addEventListener('mouseleave', stopDraw);
    canvas.addEventListener('touchstart', startDraw, {passive:false});
    canvas.addEventListener('touchmove', draw, {passive:false});
    canvas.addEventListener('touchend', stopDraw);
}

function clearSignature() {
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('canvasPlaceholder').style.display = 'block';
}

function saveSignature() {
    const canvas = document.getElementById('signatureCanvas');
    const dataURL = canvas.toDataURL('image/png');
    // Check if anything was drawn (all transparent = no drawing)
    const blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;
    if (dataURL === blank.toDataURL('image/png')) {
        alert('يرجى رسم توقيعك أولاً');
        return;
    }
    document.getElementById('signatureData').value = dataURL;
    document.getElementById('signForm').submit();
}
</script>

@endsection
