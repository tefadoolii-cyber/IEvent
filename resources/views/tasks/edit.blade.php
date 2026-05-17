@extends('layouts.app')
@section('title', 'تعديل المهمة')
@section('content')

<div class="top-header">
    <h4>تعديل المهمة</h4>
    <a href="{{ route('tasks.index') }}" class="btn btn-back">رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
@endif

<div class="card"><div class="card-body" style="padding:25px">
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="section-title">بيانات المهمة</div>
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label">عنوان المهمة *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">الموظف المكلَّف *</label>
                <select name="employee_id" id="task_employee_id" class="form-select" required>
                    <option value="">-- اختر موظف --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}"
                            data-phone="{{ $emp->phone }}"
                            data-department="{{ $emp->department }}"
                            data-position="{{ $emp->position }}"
                            data-number="{{ $emp->employee_number }}"
                            {{ old('employee_id', $task->employee_id) == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }} - {{ $emp->employee_number }}{{ $emp->department ? ' - '.$emp->department : '' }}{{ $emp->position ? ' - '.$emp->position : '' }}
                        </option>
                    @endforeach
                </select>
                <div id="task-emp-info" style="display:none;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:10px 14px;margin-top:8px;font-size:13px">
                    <div class="row g-2">
                        <div class="col-4"><span style="color:#6b7280">القسم</span><div id="t-dept" style="font-weight:600"></div></div>
                        <div class="col-4"><span style="color:#6b7280">المسمى</span><div id="t-pos" style="font-weight:600"></div></div>
                        <div class="col-4"><span style="color:#6b7280">الجوال</span><div id="t-phone" style="font-weight:600"></div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">الأولوية *</label>
                <select name="priority" class="form-select" required>
                    @foreach(['low'=>'منخفضة','medium'=>'متوسطة','high'=>'عالية','urgent'=>'عاجلة'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('priority',$task->priority)==$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">الحالة *</label>
                <select name="status" class="form-select" required>
                    @foreach(['new'=>'جديدة','in_progress'=>'قيد التنفيذ','completed'=>'مكتملة','cancelled'=>'ملغاة'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('status',$task->status)==$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ الاستحقاق</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
            </div>
            <div class="col-12">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $task->notes) }}</textarea>
            </div>
            @if($task->completed_at)
            <div class="col-12">
                <div class="alert alert-success mb-0" style="border-radius:10px;font-size:13px">
                    <i class="bi bi-check-circle"></i> تم إنجاز هذه المهمة في: <strong>{{ $task->completed_at->format('Y-m-d H:i') }}</strong>
                </div>
            </div>
            @endif
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ التعديلات</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-back">إلغاء</a>
        </div>
    </form>
</div></div>

<script>
function updateTaskEmpInfo(select) {
    const opt = select.options[select.selectedIndex];
    const info = document.getElementById('task-emp-info');
    if (!opt.value) { info.style.display = 'none'; return; }
    document.getElementById('t-dept').textContent  = opt.dataset.department || '-';
    document.getElementById('t-pos').textContent   = opt.dataset.position   || '-';
    document.getElementById('t-phone').textContent = opt.dataset.phone      || '-';
    info.style.display = 'block';
}
const taskSel = document.getElementById('task_employee_id');
taskSel.addEventListener('change', function() { updateTaskEmpInfo(this); });
// Show on load for existing employee
if (taskSel.value) updateTaskEmpInfo(taskSel);
</script>

@endsection
