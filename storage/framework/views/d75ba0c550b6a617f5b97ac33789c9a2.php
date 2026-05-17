<?php $__env->startSection('title', 'إضافة فريق'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إضافة فريق جديد</h4>
    <a href="<?php echo e(route('teams.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="<?php echo e(route('teams.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">اسم الفريق *</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المشرف</label>
                    <select name="supervisor_id" class="form-select">
                        <option value="">-- اختر --</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($emp->id); ?>" <?php echo e(old('supervisor_id')==$emp->id?'selected':''); ?>><?php echo e($emp->name); ?> — <?php echo e($emp->employee_number); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المنطقة</label>
                    <select name="region_id" class="form-select">
                        <option value="">-- اختر --</option>
                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r->id); ?>" <?php echo e(old('region_id')==$r->id?'selected':''); ?>><?php echo e($r->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الحالة</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?php echo e(old('is_active','1')=='1'?'selected':''); ?>>نشط</option>
                        <option value="0" <?php echo e(old('is_active')=='0'?'selected':''); ?>>غير نشط</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                <a href="<?php echo e(route('teams.index')); ?>" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/teams/create.blade.php ENDPATH**/ ?>