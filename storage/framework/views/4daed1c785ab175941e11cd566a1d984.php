<?php $__env->startSection('title', 'إضافة وردية'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إضافة وردية جديدة</h4>
    <a href="<?php echo e(route('shifts.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="<?php echo e(route('shifts.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">اسم الوردية *</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required placeholder="مثال: الوردية الصباحية">
                </div>
                <div class="col-md-3">
                    <label class="form-label">وقت البدء *</label>
                    <input type="time" name="start_time" class="form-control" value="<?php echo e(old('start_time')); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">وقت الانتهاء *</label>
                    <input type="time" name="end_time" class="form-control" value="<?php echo e(old('end_time')); ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label">أيام العمل</label>
                    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:6px">
                        <?php
                            $dayLabels = ['sat'=>'السبت','sun'=>'الأحد','mon'=>'الاثنين','tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس','fri'=>'الجمعة'];
                            $oldDays = old('days', []);
                        ?>
                        <?php $__currentLoopData = $dayLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label style="display:flex;align-items:center;gap:6px;cursor:pointer;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:8px 14px;font-size:13px">
                            <input type="checkbox" name="days[]" value="<?php echo e($val); ?>" <?php echo e(in_array($val, $oldDays) ? 'checked' : ''); ?>>
                            <?php echo e($label); ?>

                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                <a href="<?php echo e(route('shifts.index')); ?>" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/shifts/create.blade.php ENDPATH**/ ?>