@extends('layouts.app')
@section('title', 'رخص الجاهزية')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-shield-check"></i> رخص الجاهزية</h4>
    <a href="{{ route('readiness-licenses.create') }}" class="btn btn-add"><i class="bi bi-plus-lg"></i> إصدار رخصة</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="row g-3 mb-4">
    @foreach([
        ['val'=>$stats['total'],    'label'=>'إجمالي',  'color'=>'#374151'],
        ['val'=>$stats['active'],   'label'=>'سارية',   'color'=>'#16a34a'],
        ['val'=>$stats['expired'],  'label'=>'منتهية',  'color'=>'#d97706'],
        ['val'=>$stats['withdrawn'],'label'=>'مسحوبة',  'color'=>'#dc2626'],
    ] as $s)
    <div class="col-6 col-md-3">
        <div class="card" style="text-align:center;padding:16px;border-right:4px solid {{ $s['color'] }}">
            <div style="font-size:26px;font-weight:800;color:{{ $s['color'] }}">{{ $s['val'] }}</div>
            <div style="font-size:12px;color:#9ca3af">{{ $s['label'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="اسم الموظف..." value="{{ request('search') }}" style="font-size:13px">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="active"    {{ request('status')=='active'    ?'selected':'' }}>ساري</option>
                <option value="expired"   {{ request('status')=='expired'   ?'selected':'' }}>منتهي</option>
                <option value="withdrawn" {{ request('status')=='withdrawn' ?'selected':'' }}>مسحوب</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        @if(request()->hasAny(['search','status']))
        <div class="col-auto"><a href="{{ route('readiness-licenses.index') }}" class="btn btn-back" style="font-size:13px">مسح</a></div>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($licenses->count())
        <table class="table mb-0">
            <thead>
                <tr><th>الموظف</th><th>تاريخ الإصدار</th><th>تاريخ الانتهاء</th><th>أصدرها</th><th>الحالة</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($licenses as $lic)
                @php
                    $lc=['active'=>'#16a34a','expired'=>'#d97706','withdrawn'=>'#dc2626'];
                    $lb=['active'=>'#dcfce7','expired'=>'#fef3c7','withdrawn'=>'#fee2e2'];
                @endphp
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px">{{ $lic->employee->name }}</div>
                        <div style="font-size:11px;color:#9ca3af">{{ $lic->employee->department }}</div>
                    </td>
                    <td style="font-size:13px">{{ $lic->issued_at->format('Y-m-d') }}</td>
                    <td style="font-size:13px">{{ $lic->expires_at?->format('Y-m-d') ?? 'دائمة' }}</td>
                    <td style="font-size:13px">{{ $lic->issuer->name }}</td>
                    <td>
                        <span style="background:{{ $lb[$lic->status]??'#f3f4f6' }};color:{{ $lc[$lic->status]??'#6b7280' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ $lic->status_label }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="{{ route('readiness-licenses.show', $lic->id) }}" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            @if($lic->status === 'active')
                            <button class="btn btn-delete" style="font-size:11px;padding:4px 8px;background:#fee2e2;color:#dc2626;border:none"
                                    onclick="withdrawLicense({{ $lic->id }})"><i class="bi bi-shield-x"></i></button>
                            @endif
                            <form action="{{ route('readiness-licenses.destroy', $lic->id) }}" method="POST" onsubmit="return confirm('حذف هذه الرخصة؟')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:14px 20px">{{ $licenses->withQueryString()->links() }}</div>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-shield" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد رخص جاهزية</p>
        </div>
        @endif
    </div>
</div>

{{-- Modal سحب --}}
<div class="modal fade" id="withdrawModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">سحب رخصة الجاهزية</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="withdrawForm" method="POST">
                @csrf @method('POST')
                <div class="modal-body">
                    <label class="form-label">سبب السحب *</label>
                    <textarea name="withdrawal_reason" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-delete">سحب الرخصة</button>
                    <button type="button" class="btn btn-back" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function withdrawLicense(id) {
    document.getElementById('withdrawForm').action = '/readiness-licenses/' + id + '/withdraw';
    new bootstrap.Modal(document.getElementById('withdrawModal')).show();
}
</script>
@endsection
