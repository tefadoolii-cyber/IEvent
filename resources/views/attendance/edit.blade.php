<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل الحضور</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { font-family: 'Tajawal', sans-serif; }
        body { background: #f4f6f9; }
        .sidebar { width: 240px; background: #1a1a2e; min-height: 100vh; position: fixed; right: 0; top: 0; padding-top: 20px; z-index: 100; }
        .sidebar .logo .en { color: #4ade80; font-size: 22px; font-weight: 700; padding: 10px 20px 5px; display: block; }
        .sidebar .logo .ar { color: #9ca3af; font-size: 13px; padding: 0 20px 20px; display: block; border-bottom: 1px solid #2d2d4e; }
        .sidebar .menu-title { color: #6b7280; font-size: 11px; padding: 15px 20px 5px; }
        .sidebar a { display: flex; align-items: center; gap: 10px; color: #9ca3af; text-decoration: none; padding: 10px 20px; font-size: 14px; transition: all 0.2s; }
        .sidebar a:hover, .sidebar a.active { background: #2d2d4e; color: white; }
        .sidebar a.active { border-right: 3px solid #4ade80; color: #4ade80; }
        .main-content { margin-right: 240px; padding: 25px; }
        .top-header { background: white; border-radius: 12px; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        .top-header h4 { margin: 0; font-weight: 700; font-size: 18px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        .card-body { padding: 25px; }
        .form-label { font-weight: 500; font-size: 14px; color: #374151; }
        .form-control, .form-select { border-radius: 8px; font-size: 14px; border: 1px solid #e5e7eb; padding: 10px 14px; }
        .form-control:focus, .form-select:focus { border-color: #4ade80; box-shadow: 0 0 0 3px rgba(74,222,128,0.1); }
        .btn-save { background: #4ade80; color: #1a1a2e; font-weight: 600; border: none; border-radius: 8px; padding: 10px 25px; font-size: 15px; }
        .btn-save:hover { background: #22c55e; color: #1a1a2e; }
        .btn-back { background: #f3f4f6; color: #374151; border: none; border-radius: 8px; padding: 10px 20px; font-size: 14px; }
        .section-title { font-size: 15px; font-weight: 700; color: #1a1a2e; border-right: 3px solid #4ade80; padding-right: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo">
        <span class="en">iEvent</span>
        <span class="ar">نظام الفعاليات</span>
    </div>
    <div class="menu-title">الموارد البشرية</div>
    <a href="{{ route('employees.index') }}"><i class="bi bi-people"></i> إدارة الموظفين</a>
    <a href="{{ route('attendance.index') }}" class="active"><i class="bi bi-calendar-check"></i> الحضور والانصراف</a>
    <div class="menu-title">التشغيل</div>
    <a href="#"><i class="bi bi-clipboard-check"></i> إدارة التشغيل</a>
    <a href="#"><i class="bi bi-shield-check"></i> إدارة الجودة</a>
    <div class="menu-title">النظام</div>
    <a href="#"><i class="bi bi-bar-chart"></i> إدارة البيانات</a>
    <a href="#"><i class="bi bi-headset"></i> الدعم الفني</a>
</div>

<div class="main-content">
    <div class="top-header">
        <h4>تعديل سجل الحضور</h4>
        <a href="{{ route('attendance.index') }}" class="btn btn-back">
            <i class="bi bi-arrow-right"></i> رجوع
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="section-title">بيانات الحضور</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">الموظف *</label>
                        <select name="employee_id" class="form-select" required>
                            <option value="">-- اختر موظف --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $attendance->employee_id == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} - {{ $employee->employee_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">التاريخ *</label>
                        <input type="date" name="date" class="form-control" value="{{ $attendance->date }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">وقت الحضور</label>
                        <input type="time" name="check_in" class="form-control" value="{{ $attendance->check_in }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">وقت الانصراف</label>
                        <input type="time" name="check_out" class="form-control" value="{{ $attendance->check_out }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الحالة *</label>
                        <select name="status" class="form-select" required>
                            <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>حاضر</option>
                            <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>غائب</option>
                            <option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>متأخر</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3">{{ $attendance->notes }}</textarea>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-save">
                        <i class="bi bi-check-lg"></i> حفظ التعديل
                    </button>
                    <a href="{{ route('attendance.index') }}" class="btn btn-back">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>