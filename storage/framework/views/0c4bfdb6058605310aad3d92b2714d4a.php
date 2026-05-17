<?php $__env->startSection('title', 'إصدار رخصة جاهزية'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إصدار رخصة جاهزية</h4>
    <a href="<?php echo e(route('readiness-licenses.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="<?php echo e(route('readiness-licenses.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">الموظف *</label>
                    <select name="employee_id" class="form-select" required>
                        <option value="">-- اختر --</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($emp->id); ?>" <?php echo e(old('employee_id')==$emp->id?'selected':''); ?>><?php echo e($emp->name); ?> — <?php echo e($emp->employee_number); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ الإصدار *</label>
                    <input type="date" name="issued_at" class="form-control" value="<?php echo e(old('issued_at', date('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ الانتهاء</label>
                    <input type="date" name="expires_at" class="form-control" value="<?php echo e(old('expires_at')); ?>">
                    <div style="font-size:11px;color:#9ca3af;margin-top:3px">اتركه فارغاً للرخصة الدائمة</div>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save"><i class="bi bi-shield-check"></i> إصدار الرخصة</button>
                <a href="<?php echo e(route('readiness-licenses.index')); ?>" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/readiness-licenses/create.blade.php ENDPATH**/ ?>