<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>التقديم على وظيفة: {{ $jobOpening->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { font-family: 'Tajawal', sans-serif; }
        body { background: #f4f6f9; }
        .header { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); color: white; padding: 30px 20px; }
        .header h2 { font-weight: 800; margin: 0; }
        .card { border: none; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.07); }
        .form-label { font-weight: 600; font-size: 14px; color: #374151; }
        .form-label .req { color: #dc2626; }
        .form-control, .form-select { border-radius: 8px; border: 1.5px solid #e5e7eb; padding: 10px 14px; font-size: 14px; }
        .form-control:focus, .form-select:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        .btn-submit { background: #2563eb; color: white; border: none; border-radius: 10px; padding: 12px 36px; font-size: 16px; font-weight: 700; }
        .btn-submit:hover { background: #1d4ed8; color: white; }
        .section-badge { background: #eff6ff; color: #1d4ed8; padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 20px; display: inline-block; }
        .file-hint { font-size: 11px; color: #9ca3af; margin-top: 4px; }
    </style>
</head>
<body>

<div class="header">
    <div class="container">
        <a href="{{ route('apply') }}" style="color:rgba(255,255,255,.7);font-size:13px;text-decoration:none">
            <i class="bi bi-arrow-right me-1"></i>الوظائف المتاحة
        </a>
        <h2 class="mt-2">{{ $jobOpening->title }}</h2>
        @if($jobOpening->department)
        <span style="background:rgba(255,255,255,.2);padding:3px 12px;border-radius:20px;font-size:13px">
            <i class="bi bi-building me-1"></i>{{ $jobOpening->department }}
        </span>
        @endif
        @if($jobOpening->deadline)
        <span style="background:rgba(255,255,255,.15);padding:3px 12px;border-radius:20px;font-size:13px;margin-right:8px">
            <i class="bi bi-clock me-1"></i>آخر موعد: {{ $jobOpening->deadline->format('Y-m-d') }}
        </span>
        @endif
    </div>
</div>

<div class="container py-4">

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        @foreach($errors->all() as $e)<p class="mb-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $e }}</p>@endforeach
    </div>
    @endif

    @if($jobOpening->description)
    <div class="card mb-4">
        <div class="card-body p-4">
            <div class="section-badge"><i class="bi bi-info-circle me-1"></i>عن الوظيفة</div>
            <p style="font-size:14px;color:#374151;line-height:1.9;margin:0">{{ $jobOpening->description }}</p>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-body p-4">
            <div class="section-badge"><i class="bi bi-pencil-square me-1"></i>نموذج التقديم</div>

            <form action="{{ route('apply.store', $jobOpening->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                @foreach($jobOpening->fields ?? [] as $field)
                @php
                    $key  = $field['key'];
                    $req  = $field['required'] ?? false;
                    $def  = $availableFields[$key] ?? [];
                    $type = $def['type'] ?? 'text';
                    $lbl  = $def['label'] ?? $key;
                @endphp

                @if($type === 'textarea')
                <div class="col-12">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <textarea name="{{ $key }}" class="form-control" rows="3" {{ $req ? 'required' : '' }}>{{ old($key) }}</textarea>
                </div>

                @elseif($type === 'select' && $key === 'nationality')
                <div class="col-md-6">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <select name="{{ $key }}" class="form-select" {{ $req ? 'required' : '' }}>
                        <option value="">-- اختر --</option>
                        @foreach($nationalities as $n)
                        <option value="{{ $n->value }}" {{ old($key) == $n->value ? 'selected' : '' }}>{{ $n->label }}</option>
                        @endforeach
                    </select>
                </div>

                @elseif($type === 'select' && $key === 'education_level')
                <div class="col-md-6">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <select name="{{ $key }}" class="form-select" {{ $req ? 'required' : '' }}>
                        <option value="">-- اختر --</option>
                        @foreach($educationLevels as $e)
                        <option value="{{ $e->value }}" {{ old($key) == $e->value ? 'selected' : '' }}>{{ $e->label }}</option>
                        @endforeach
                    </select>
                </div>

                @elseif($type === 'image')
                <div class="col-md-6">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <input type="file" name="{{ $key }}" class="form-control" accept="image/jpeg,image/png,image/webp" {{ $req ? 'required' : '' }}>
                    <div class="file-hint">JPG, PNG — بحد أقصى 3 MB</div>
                </div>

                @elseif($type === 'file')
                <div class="col-md-6">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <input type="file" name="{{ $key }}" class="form-control" accept=".pdf,.doc,.docx" {{ $req ? 'required' : '' }}>
                    <div class="file-hint">PDF, DOC — بحد أقصى 5 MB</div>
                </div>

                @elseif($type === 'number')
                <div class="col-md-6">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <input type="number" name="{{ $key }}" class="form-control" min="0" value="{{ old($key) }}" {{ $req ? 'required' : '' }}>
                </div>

                @elseif($type === 'date')
                <div class="col-md-6">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <input type="date" name="{{ $key }}" class="form-control" value="{{ old($key) }}" {{ $req ? 'required' : '' }}>
                </div>

                @elseif($type === 'email')
                <div class="col-md-6">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <input type="email" name="{{ $key }}" class="form-control" value="{{ old($key) }}" {{ $req ? 'required' : '' }}>
                </div>

                @elseif($type === 'tel')
                <div class="col-md-6">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <input type="tel" name="{{ $key }}" class="form-control" value="{{ old($key) }}" {{ $req ? 'required' : '' }}>
                </div>

                @else
                <div class="col-md-6">
                    <label class="form-label">{{ $lbl }} @if($req)<span class="req">*</span>@endif</label>
                    <input type="text" name="{{ $key }}" class="form-control" value="{{ old($key) }}" {{ $req ? 'required' : '' }}>
                </div>
                @endif

                @endforeach

                </div>

                <div class="mt-4 d-flex gap-2 align-items-center">
                    <button type="submit" class="btn-submit"><i class="bi bi-send me-2"></i>إرسال الطلب</button>
                    <a href="{{ route('apply') }}" style="color:#6b7280;font-size:14px;text-decoration:none">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
