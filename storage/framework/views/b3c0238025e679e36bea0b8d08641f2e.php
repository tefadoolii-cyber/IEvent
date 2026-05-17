<?php $__env->startSection('title', 'استبيان جديد'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-clipboard-data"></i> إنشاء استبيان جديد</h4>
    <a href="<?php echo e(route('surveys.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>

<form action="<?php echo e(route('surveys.store')); ?>" method="POST">
<?php echo csrf_field(); ?>
<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><span style="font-weight:600">بيانات الاستبيان</span></div>
            <div class="card-body" style="padding:20px">
                <div class="mb-3">
                    <label class="form-label">العنوان *</label>
                    <input type="text" name="title" class="form-control" value="<?php echo e(old('title')); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control" rows="2"><?php echo e(old('description')); ?></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">الحالة *</label>
                        <select name="status" class="form-select" required>
                            <option value="draft"  <?php echo e(old('status','draft')=='draft'  ?'selected':''); ?>>مسودة</option>
                            <option value="active" <?php echo e(old('status')=='active' ?'selected':''); ?>>نشط</option>
                            <option value="closed" <?php echo e(old('status')=='closed' ?'selected':''); ?>>مغلق</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ البداية</label>
                        <input type="date" name="starts_at" class="form-control" value="<?php echo e(old('starts_at')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ الانتهاء</label>
                        <input type="date" name="ends_at" class="form-control" value="<?php echo e(old('ends_at')); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" style="background:#f9fafb;border:2px dashed #e5e7eb">
            <div class="card-body" style="padding:16px;font-size:13px;color:#6b7280">
                <i class="bi bi-info-circle" style="color:#3b82f6"></i>
                <strong> ملاحظة:</strong> يمكنك إضافة الأسئلة بعد حفظ الاستبيان من صفحة التفاصيل.
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-save"><i class="bi bi-save"></i> حفظ الاستبيان</button>
    <a href="<?php echo e(route('surveys.index')); ?>" class="btn btn-back">إلغاء</a>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/surveys/create.blade.php ENDPATH**/ ?>