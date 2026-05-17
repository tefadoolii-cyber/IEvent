<?php $__env->startSection('title', 'إضافة حدث'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إضافة حدث جديد</h4>
    <a href="<?php echo e(route('events.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="<?php echo e(route('events.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="section-title">بيانات الحدث</div>
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <label class="form-label">اسم الحدث *</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">نوع الحدث</label>
                    <?php if($eventTypes->count()): ?>
                    <select name="type" class="form-select">
                        <option value="">-- اختر --</option>
                        <?php $__currentLoopData = $eventTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t->value_ar); ?>" <?php echo e(old('type')==$t->value_ar ? 'selected':''); ?>><?php echo e($t->value_ar); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php else: ?>
                    <input type="text" name="type" class="form-control" value="<?php echo e(old('type')); ?>" placeholder="مثال: مؤتمر، معرض...">
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ البدء *</label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo e(old('start_date')); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ الانتهاء</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo e(old('end_date')); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">الموقع</label>
                    <select name="location_id" class="form-select">
                        <option value="">-- اختر --</option>
                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($loc->id); ?>" <?php echo e(old('location_id')==$loc->id ? 'selected':''); ?>><?php echo e($loc->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="planning" <?php echo e(old('status','planning')=='planning'  ? 'selected':''); ?>>تخطيط</option>
                        <option value="active"   <?php echo e(old('status')=='active'    ? 'selected':''); ?>>نشط</option>
                        <option value="completed"<?php echo e(old('status')=='completed' ? 'selected':''); ?>>مكتمل</option>
                        <option value="cancelled"<?php echo e(old('status')=='cancelled' ? 'selected':''); ?>>ملغي</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">مدير الحدث</label>
                    <select name="manager_id" class="form-select">
                        <option value="">-- اختر --</option>
                        <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->id); ?>" <?php echo e(old('manager_id')==$m->id ? 'selected':''); ?>><?php echo e($m->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الميزانية (ر.س)</label>
                    <input type="number" name="budget" class="form-control" value="<?php echo e(old('budget')); ?>" min="0" step="0.01">
                </div>
                <div class="col-12">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo e(old('description')); ?></textarea>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                <a href="<?php echo e(route('events.index')); ?>" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/events/create.blade.php ENDPATH**/ ?>