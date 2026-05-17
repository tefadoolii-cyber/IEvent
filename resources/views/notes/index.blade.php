@extends('layouts.app')
@section('title', 'الملاحظات')
@section('content')

<div class="top-header">
    <h4><i class="bi bi-chat-square-text"></i> سجل الملاحظات</h4>
</div>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-3">
            <select name="model_type" class="form-select" style="font-size:13px">
                <option value="">كل الأنواع</option>
                <option value="App\Models\Employee" {{ request('model_type')=='App\Models\Employee'?'selected':'' }}>موظف</option>
                <option value="App\Models\Event"    {{ request('model_type')=='App\Models\Event'?'selected':'' }}>حدث</option>
                <option value="App\Models\Visit"    {{ request('model_type')=='App\Models\Visit'?'selected':'' }}>زيارة</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="severity" class="form-select" style="font-size:13px">
                <option value="">كل الخطورة</option>
                <option value="info"     {{ request('severity')=='info'     ?'selected':'' }}>معلومة</option>
                <option value="warning"  {{ request('severity')=='warning'  ?'selected':'' }}>تحذير</option>
                <option value="critical" {{ request('severity')=='critical' ?'selected':'' }}>حرج</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> فلترة</button>
        </div>
        @if(request()->hasAny(['model_type','severity']))
        <div class="col-auto"><a href="{{ route('notes.index') }}" class="btn btn-back" style="font-size:13px">مسح</a></div>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($notes->count())
        <table class="table mb-0">
            <thead>
                <tr><th>الملاحظة</th><th>المرتبطة بـ</th><th>النوع</th><th>الخطورة</th><th>بواسطة</th><th>التاريخ</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($notes as $note)
                <tr>
                    <td style="font-size:13px;max-width:250px">{{ Str::limit($note->note, 80) }}</td>
                    <td>
                        <div style="font-size:12px;color:#6b7280">{{ class_basename($note->model_type) }}</div>
                        <div style="font-size:11px;color:#9ca3af;font-family:monospace">#{{ $note->model_id }}</div>
                    </td>
                    <td style="font-size:12px">{{ $note->noteType?->value_ar ?? '-' }}</td>
                    <td>
                        @php
                            $sc=['info'=>'#2563eb','warning'=>'#d97706','critical'=>'#dc2626'];
                            $sb=['info'=>'#dbeafe','warning'=>'#fef3c7','critical'=>'#fee2e2'];
                        @endphp
                        <span style="background:{{ $sb[$note->severity]??'#f3f4f6' }};color:{{ $sc[$note->severity]??'#6b7280' }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ $note->severity_label }}
                        </span>
                    </td>
                    <td style="font-size:13px">{{ $note->creator?->name ?? '-' }}</td>
                    <td style="font-size:12px;color:#9ca3af">{{ $note->created_at->format('Y-m-d') }}</td>
                    <td>
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('حذف هذه الملاحظة؟')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:14px 20px">{{ $notes->withQueryString()->links() }}</div>
        @else
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-chat-square" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد ملاحظات</p>
        </div>
        @endif
    </div>
</div>
@endsection
