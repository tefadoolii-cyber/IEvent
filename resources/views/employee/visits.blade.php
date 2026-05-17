@extends('employee.layout')
@section('title', 'زياراتي')
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="welcome">
    <h2><i class="bi bi-geo-alt-fill"></i> زياراتي الميدانية</h2>
    <p>سجّل وتابع زياراتك الميدانية</p>
</div>

<div class="row g-3">
    {{-- نموذج تسجيل زيارة جديدة --}}
    <div class="col-lg-4">
        <div class="card">
            <h5 style="font-weight:700;margin-bottom:18px"><i class="bi bi-plus-circle" style="color:#d4af37"></i> تسجيل زيارة جديدة</h5>

            @if($errors->any())
            <div class="alert alert-danger" style="font-size:13px">
                @foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach
            </div>
            @endif

            <form action="{{ route('portal.visits.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" style="font-size:13px;font-weight:600">الموقع *</label>
                    <select name="location_id" class="form-select" style="font-size:13px" required>
                        <option value="">-- اختر الموقع --</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id')==$loc->id?'selected':'' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-size:13px;font-weight:600">تاريخ الزيارة *</label>
                    <input type="date" name="visit_date" class="form-control" style="font-size:13px" value="{{ old('visit_date', date('Y-m-d')) }}" required>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label" style="font-size:13px;font-weight:600">وقت الوصول</label>
                        <input type="time" name="check_in_time" class="form-control" style="font-size:13px" value="{{ old('check_in_time') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label" style="font-size:13px;font-weight:600">وقت المغادرة</label>
                        <input type="time" name="check_out_time" class="form-control" style="font-size:13px" value="{{ old('check_out_time') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-size:13px;font-weight:600">الموقع الجغرافي</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" step="any" name="lat" id="lat" class="form-control" style="font-size:13px" placeholder="خط العرض" value="{{ old('lat') }}">
                        </div>
                        <div class="col-6">
                            <input type="number" step="any" name="lng" id="lng" class="form-control" style="font-size:13px" placeholder="خط الطول" value="{{ old('lng') }}">
                        </div>
                    </div>
                    <button type="button" onclick="getGPS()" class="btn mt-2 w-100" style="background:#f3f4f6;font-size:12px;padding:6px">
                        <i class="bi bi-crosshair"></i> تحديد موقعي تلقائياً
                    </button>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-size:13px;font-weight:600">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="2" style="font-size:13px">{{ old('notes') }}</textarea>
                </div>
                <button type="submit" class="btn-action w-100" style="justify-content:center">
                    <i class="bi bi-send"></i> تسجيل الزيارة
                </button>
            </form>
        </div>
    </div>

    {{-- قائمة الزيارات --}}
    <div class="col-lg-8">
        <div class="card" style="padding:0">
            <div style="padding:18px 20px;border-bottom:1px solid #f0f0f0;font-weight:700;font-size:15px">
                <i class="bi bi-list-ul" style="color:#d4af37"></i> سجل زياراتي
            </div>
            @php
                $statusLabels = ['pending'=>'معلقة','completed'=>'مكتملة','cancelled'=>'ملغاة'];
                $statusColors = ['pending'=>'#d97706','completed'=>'#16a34a','cancelled'=>'#dc2626'];
                $statusBgs    = ['pending'=>'#fef3c7','completed'=>'#dcfce7','cancelled'=>'#fee2e2'];
            @endphp
            @if($visits instanceof \Illuminate\Pagination\LengthAwarePaginator ? $visits->count() : $visits->count())
            <div class="table-responsive">
            <table class="table mb-0" style="font-size:13px">
                <thead>
                    <tr><th>الموقع</th><th>التاريخ</th><th>الوصول</th><th>المغادرة</th><th>الحالة</th><th>إحداثيات</th></tr>
                </thead>
                <tbody>
                    @foreach($visits as $v)
                    <tr>
                        <td style="font-weight:600">{{ $v->location?->name ?? '-' }}</td>
                        <td>{{ $v->visit_date->format('Y-m-d') }}</td>
                        <td>{{ $v->check_in_time ?? '-' }}</td>
                        <td>{{ $v->check_out_time ?? '-' }}</td>
                        <td>
                            <span style="background:{{ $statusBgs[$v->status]??'#f3f4f6' }};color:{{ $statusColors[$v->status]??'#6b7280' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                                {{ $statusLabels[$v->status] ?? $v->status }}
                            </span>
                        </td>
                        <td style="color:#9ca3af;font-family:monospace;font-size:11px">
                            @if($v->lat && $v->lng)
                                {{ number_format($v->lat,4) }}, {{ number_format($v->lng,4) }}
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @if($visits instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div style="padding:12px 20px">{{ $visits->links() }}</div>
            @endif
            @else
            <div class="text-center py-5" style="color:#9ca3af">
                <i class="bi bi-geo-alt" style="font-size:36px"></i>
                <p class="mt-2 mb-0">لا توجد زيارات مسجلة</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function getGPS() {
    if (!navigator.geolocation) { alert('المتصفح لا يدعم تحديد الموقع'); return; }
    navigator.geolocation.getCurrentPosition(function(pos) {
        document.getElementById('lat').value = pos.coords.latitude.toFixed(6);
        document.getElementById('lng').value = pos.coords.longitude.toFixed(6);
    }, function() {
        alert('تعذّر تحديد الموقع');
    });
}
</script>
@endsection
