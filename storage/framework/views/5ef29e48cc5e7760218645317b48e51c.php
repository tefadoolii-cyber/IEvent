<?php $__env->startSection('title', 'إضافة إسناد'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إضافة إسناد جديد</h4>
    <a href="<?php echo e(route('assignments.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>

<div class="card"><div class="card-body" style="padding:25px">
    <form action="<?php echo e(route('assignments.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">الموظف *</label>
                <select name="employee_id" id="asgn_employee_id" class="form-select" required>
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
                <div id="asgn-emp-info" style="display:none;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:10px;margin-top:8px;font-size:13px">
                    <div class="row g-1">
                        <div class="col-4"><span style="color:#6b7280;font-size:11px">القسم</span><div id="ae-dept" style="font-weight:600;font-size:13px"></div></div>
                        <div class="col-4"><span style="color:#6b7280;font-size:11px">المسمى</span><div id="ae-pos" style="font-weight:600;font-size:13px"></div></div>
                        <div class="col-4"><span style="color:#6b7280;font-size:11px">الجوال</span><div id="ae-phone" style="font-weight:600;font-size:13px"></div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">المشرف</label>
                <select name="supervisor_id" class="form-select">
                    <option value="">-- لا يوجد --</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($emp->id); ?>" <?php echo e(old('supervisor_id') == $emp->id ? 'selected' : ''); ?>>
                            <?php echo e($emp->name); ?> - <?php echo e($emp->employee_number); ?><?php echo e($emp->department ? ' - '.$emp->department : ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">الموقع</label>
                <select name="location_id" class="form-select">
                    <option value="">-- لا يوجد --</option>
                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($loc->id); ?>" <?php echo e(old('location_id') == $loc->id ? 'selected' : ''); ?>><?php echo e($loc->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">الشركة</label>
                <select name="company_id" class="form-select">
                    <option value="">-- لا يوجد --</option>
                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $co): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($co->id); ?>" <?php echo e(old('company_id') == $co->id ? 'selected' : ''); ?>><?php echo e($co->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الدور / المهمة</label>
                <input type="text" name="role" class="form-control" value="<?php echo e(old('role')); ?>" placeholder="مثال: مشرف، عامل، مندوب">
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ البداية *</label>
                <input type="date" name="start_date" class="form-control" value="<?php echo e(old('start_date')); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ النهاية</label>
                <input type="date" name="end_date" class="form-control" value="<?php echo e(old('end_date')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة *</label>
                <select name="status" class="form-select" required>
                    <?php $__currentLoopData = ['active'=>'نشط','completed'=>'منتهي','cancelled'=>'ملغي']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v); ?>" <?php echo e(old('status','active') == $v ? 'selected' : ''); ?>><?php echo e($l); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes')); ?></textarea>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
            <a href="<?php echo e(route('assignments.index')); ?>" class="btn btn-back">إلغاء</a>
        </div>
    </form>
</div></div>

<script>
function updateAsgnEmpInfo(select) {
    const opt = select.options[select.selectedIndex];
    const info = document.getElementById('asgn-emp-info');
    if (!opt.value) { info.style.display = 'none'; return; }
    document.getElementById('ae-dept').textContent  = opt.dataset.department || '-';
    document.getElementById('ae-pos').textContent   = opt.dataset.position   || '-';
    document.getElementById('ae-phone').textContent = opt.dataset.phone      || '-';
    info.style.display = 'block';
}
const asgnSel = document.getElementById('asgn_employee_id');
asgnSel.addEventListener('change', function() { updateAsgnEmpInfo(this); });
<?php if(old('employee_id')): ?> updateAsgnEmpInfo(asgnSel); <?php endif; ?>
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/assignments/create.blade.php ENDPATH**/ ?>