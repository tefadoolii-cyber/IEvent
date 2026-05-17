@extends('layouts.app')
@section('title', 'تفاصيل الاستبيان')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-clipboard-data"></i> {{ $survey->title }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('surveys.edit', $survey->id) }}" class="btn btn-edit"><i class="bi bi-pencil"></i> تعديل</a>
        <a href="{{ route('surveys.index') }}" class="btn btn-back">رجوع</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

@php
    $sc=['draft'=>'#6b7280','active'=>'#16a34a','closed'=>'#dc2626'];
    $sb=['draft'=>'#f3f4f6','active'=>'#dcfce7','closed'=>'#fee2e2'];
@endphp

<div class="row g-3">
    {{-- معلومات الاستبيان --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><span style="font-weight:600">معلومات الاستبيان</span></div>
            <div class="card-body" style="padding:20px;font-size:13px">
                <div style="text-align:center;margin-bottom:16px">
                    <span style="background:{{ $sb[$survey->status]??'#f3f4f6' }};color:{{ $sc[$survey->status]??'#6b7280' }};padding:6px 18px;border-radius:20px;font-size:13px;font-weight:700">
                        {{ $survey->status_label }}
                    </span>
                </div>
                @if($survey->description)
                <p style="color:#6b7280">{{ $survey->description }}</p>
                @endif
                <div class="info-row d-flex justify-content-between py-2" style="border-bottom:1px solid #f0f0f0">
                    <span style="color:#6b7280">الأسئلة</span><strong>{{ $survey->questions->count() }}</strong>
                </div>
                <div class="info-row d-flex justify-content-between py-2" style="border-bottom:1px solid #f0f0f0">
                    <span style="color:#6b7280">الردود</span><strong>{{ $survey->responses->count() }}</strong>
                </div>
                <div class="info-row d-flex justify-content-between py-2" style="border-bottom:1px solid #f0f0f0">
                    <span style="color:#6b7280">أنشأه</span><strong>{{ $survey->creator?->name ?? '—' }}</strong>
                </div>
                @if($survey->starts_at)
                <div class="info-row d-flex justify-content-between py-2" style="border-bottom:1px solid #f0f0f0">
                    <span style="color:#6b7280">البداية</span><strong>{{ $survey->starts_at->format('Y-m-d') }}</strong>
                </div>
                @endif
                @if($survey->ends_at)
                <div class="info-row d-flex justify-content-between py-2">
                    <span style="color:#6b7280">الانتهاء</span><strong>{{ $survey->ends_at->format('Y-m-d') }}</strong>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- الأسئلة --}}
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span style="font-weight:600">الأسئلة ({{ $survey->questions->count() }})</span>
            </div>
            <div class="card-body" style="padding:20px">
                {{-- إضافة سؤال --}}
                <form action="{{ route('surveys.questions.add', $survey->id) }}" method="POST" class="mb-4" style="background:#f9fafb;padding:16px;border-radius:10px">
                    @csrf
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <input type="text" name="question" class="form-control" placeholder="نص السؤال *" style="font-size:13px" required>
                        </div>
                        <div class="col-md-4">
                            <select name="type" class="form-select" style="font-size:13px" onchange="toggleOptions(this)">
                                <option value="text">نص حر</option>
                                <option value="rating">تقييم (1-5)</option>
                                <option value="single_choice">اختيار واحد</option>
                                <option value="multiple_choice">اختيار متعدد</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="required" id="req">
                                <label class="form-check-label" for="req" style="font-size:12px">مطلوب</label>
                            </div>
                        </div>
                    </div>
                    <div id="options-field" style="display:none" class="mb-2">
                        <textarea name="options" class="form-control" rows="3" placeholder="أدخل كل خيار في سطر منفصل..." style="font-size:12px"></textarea>
                    </div>
                    <button type="submit" class="btn btn-save" style="font-size:12px;padding:6px 14px"><i class="bi bi-plus"></i> إضافة سؤال</button>
                </form>

                @forelse($survey->questions as $q)
                <div style="padding:12px;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:10px">
                    <div class="d-flex justify-content-between align-items-start">
                        <div style="flex:1">
                            <div style="font-weight:600;font-size:13px">
                                {{ $loop->iteration }}. {{ $q->question }}
                                @if($q->required)<span style="color:#dc2626;margin-right:4px">*</span>@endif
                            </div>
                            <span style="font-size:11px;color:#9ca3af;background:#f3f4f6;padding:2px 8px;border-radius:10px">{{ $q->type_label }}</span>
                            @if($q->options)
                            <div style="margin-top:8px;display:flex;flex-wrap:wrap;gap:4px">
                                @foreach($q->options as $opt)
                                <span style="background:#eff6ff;color:#3b82f6;padding:2px 8px;border-radius:10px;font-size:11px">{{ $opt }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <form action="{{ route('surveys.questions.remove', [$survey->id, $q->id]) }}" method="POST" onsubmit="return confirm('حذف هذا السؤال؟')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="color:#9ca3af;font-size:13px;text-align:center">لا توجد أسئلة بعد</p>
                @endforelse
            </div>
        </div>

        {{-- الردود --}}
        @if($survey->responses->count())
        <div class="card">
            <div class="card-header"><span style="font-weight:600">الردود ({{ $survey->responses->count() }})</span></div>
            <div class="card-body p-0">
                <table class="table mb-0" style="font-size:13px">
                    <thead>
                        <tr><th>الموظف</th><th>تاريخ الرد</th></tr>
                    </thead>
                    <tbody>
                        @foreach($survey->responses as $r)
                        <tr>
                            <td>{{ $r->employee?->name ?? '—' }}</td>
                            <td style="color:#9ca3af">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function toggleOptions(sel) {
    document.getElementById('options-field').style.display =
        ['single_choice','multiple_choice'].includes(sel.value) ? 'block' : 'none';
}
</script>
@endsection
