@extends('layouts.app')
@section('title', 'تفاصيل الجهاز')
@section('content')

<div class="top-header">
    <h4>{{ $asset->name }}</h4>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i> تعديل</a>
        <a href="{{ route('assets.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-laptop"></i> بيانات الجهاز</span></div>
            <div class="card-body" style="padding:20px">
                @php
                    $sColors = ['available'=>'#16a34a','assigned'=>'#d97706','maintenance'=>'#2563eb','retired'=>'#dc2626'];
                    $sBgs    = ['available'=>'#dcfce7','assigned'=>'#fef3c7','maintenance'=>'#dbeafe','retired'=>'#fee2e2'];
                @endphp
                @foreach([
                    'الاسم'            => $asset->name,
                    'النوع'            => $asset->type,
                    'الماركة'          => $asset->brand,
                    'الموديل'          => $asset->model,
                    'الرقم التسلسلي'  => $asset->serial_number,
                    'تاريخ الشراء'    => $asset->purchase_date?->format('Y-m-d'),
                    'سعر الشراء'       => $asset->purchase_price ? number_format($asset->purchase_price,2).' ر.س' : null,
                ] as $l => $v)
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                    <span style="color:#6b7280">{{ $l }}</span>
                    <span style="font-weight:600">{{ $v ?? '-' }}</span>
                </div>
                @endforeach
                <div style="display:flex;justify-content:space-between;padding:8px 0;font-size:13px">
                    <span style="color:#6b7280">الحالة</span>
                    <span style="background:{{ $sBgs[$asset->status]??'#f3f4f6' }};color:{{ $sColors[$asset->status]??'#6b7280' }};padding:3px 9px;border-radius:20px;font-size:12px">{{ $asset->status_label }}</span>
                </div>
                @if($asset->notes)
                <div style="margin-top:10px;background:#f9fafb;border-radius:8px;padding:10px;font-size:13px;color:#374151">{{ $asset->notes }}</div>
                @endif
            </div>
        </div>

        @if($asset->status === 'available')
        <div class="card">
            <div class="card-header"><span style="font-weight:600"><i class="bi bi-person-plus"></i> تسليم لموظف</span></div>
            <div class="card-body" style="padding:20px">
                <form action="{{ route('assets.assign', $asset->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">الموظف *</label>
                        <select name="employee_id" id="assign_employee_id" class="form-select" required>
                            <option value="">-- اختر موظف --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}"
                                    data-phone="{{ $emp->phone }}"
                                    data-position="{{ $emp->position }}"
                                    data-department="{{ $emp->department }}"
                                    data-number="{{ $emp->employee_number }}">
                                    {{ $emp->name }} - {{ $emp->employee_number }}{{ $emp->department ? ' - '.$emp->department : '' }}
                                </option>
                            @endforeach
                        </select>

                        {{-- معلومات الموظف المختار --}}
                        <div id="assign-emp-info" style="display:none;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:10px;margin-top:8px;font-size:13px">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div style="color:#6b7280;font-size:11px">المسمى الوظيفي</div>
                                    <div id="a-position" style="font-weight:600"></div>
                                </div>
                                <div class="col-6">
                                    <div style="color:#6b7280;font-size:11px">رقم الجوال</div>
                                    <div id="a-phone" style="font-weight:600"></div>
                                </div>
                                <div class="col-12">
                                    <div style="color:#6b7280;font-size:11px">القسم</div>
                                    <div id="a-department" style="font-weight:600"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-save w-100"><i class="bi bi-send"></i> تسليم الجهاز</button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600"><i class="bi bi-clock-history"></i> سجل التسليم والاستلام</span>
            </div>
            <div class="card-body p-0">
                @if($asset->assignments->count() > 0)
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>الموظف</th>
                            <th>القسم</th>
                            <th>تاريخ التسليم</th>
                            <th>تاريخ الاستلام</th>
                            <th>الحالة</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asset->assignments as $asgn)
                        <tr>
                            <td>
                                <div style="font-weight:600;font-size:14px">{{ $asgn->employee->name ?? '-' }}</div>
                                <div style="color:#9ca3af;font-size:11px;font-family:monospace">{{ $asgn->employee->employee_number ?? '' }}</div>
                            </td>
                            <td style="font-size:13px;color:#6b7280">{{ $asgn->employee->department ?? '-' }}</td>
                            <td style="font-size:13px">{{ $asgn->delivered_at?->format('Y-m-d H:i') ?? '-' }}</td>
                            <td style="font-size:13px">{{ $asgn->returned_at?->format('Y-m-d H:i') ?? '-' }}</td>
                            <td>
                                @if($asgn->isActive())
                                    <span style="background:#fef3c7;color:#d97706;padding:3px 9px;border-radius:20px;font-size:12px">جارٍ</span>
                                @else
                                    <span style="background:#dcfce7;color:#16a34a;padding:3px 9px;border-radius:20px;font-size:12px">مُعاد</span>
                                @endif
                            </td>
                            <td>
                                @if($asgn->isActive())
                                <form action="{{ route('assets.return', $asgn->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-save" style="font-size:12px;padding:4px 10px" onclick="return confirm('تأكيد استلام الجهاز؟')">
                                        <i class="bi bi-arrow-return-left"></i> استلام
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center py-4" style="color:#9ca3af">
                    <i class="bi bi-inbox" style="font-size:30px"></i>
                    <p class="mt-2">لم يُسلَّم هذا الجهاز بعد</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
const assignSel = document.getElementById('assign_employee_id');
if (assignSel) {
    assignSel.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        const info = document.getElementById('assign-emp-info');
        if (!opt.value) { info.style.display = 'none'; return; }
        document.getElementById('a-position').textContent   = opt.dataset.position   || '-';
        document.getElementById('a-phone').textContent      = opt.dataset.phone       || '-';
        document.getElementById('a-department').textContent = opt.dataset.department  || '-';
        info.style.display = 'block';
    });
}
</script>

@endsection
