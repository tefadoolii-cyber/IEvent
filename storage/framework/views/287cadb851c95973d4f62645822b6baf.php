<?php $__env->startSection('title', 'إضافة مهمة'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إضافة مهمة جديدة</h4>
    <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>

<div class="card"><div class="card-body" style="padding:25px">
    <form action="<?php echo e(route('tasks.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="section-title">بيانات المهمة</div>
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label">عنوان المهمة *</label>
                <input type="text" name="title" class="form-control" value="<?php echo e(old('title')); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">الموظف المكلَّف *</label>
                <select name="employee_id" id="task_employee_id" class="form-select" required>
                    <option value="">-- اختر موظف --</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($emp->id); ?>"
                            data-phone="<?php echo e($emp->phone); ?>"
                            data-department="<?php echo e($emp->department); ?>"
                            data-position="<?php echo e($emp->position); ?>"
                            data-number="<?php echo e($emp->employee_number); ?>"
                            <?php echo e(old('employee_id') == $emp->id ? 'selected' : ''); ?>>
                            <?php echo e($emp->name); ?> - <?php echo e($emp->employee_number); ?><?php echo e($emp->department ? ' - '.$emp->department : ''); ?><?php echo e($emp->position ? ' - '.$emp->position : ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php $__currentLoopData = ['low'=>'منخفضة','medium'=>'متوسطة','high'=>'عالية','urgent'=>'عاجلة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v); ?>" <?php echo e(old('priority','medium')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">الحالة *</label>
                <select name="status" class="form-select" required>
                    <?php $__currentLoopData = ['new'=>'جديدة','in_progress'=>'قيد التنفيذ','completed'=>'مكتملة','cancelled'=>'ملغاة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v); ?>" <?php echo e(old('status','new')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ الاستحقاق</label>
                <input type="date" name="due_date" class="form-control" value="<?php echo e(old('due_date')); ?>">
            </div>
            <div class="col-12">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="4"><?php echo e(old('description')); ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
            <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-back">إلغاء</a>
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
<?php if(old('employee_id')): ?> updateTaskEmpInfo(taskSel); <?php endif; ?>
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/tasks/create.blade.php ENDPATH**/ ?>