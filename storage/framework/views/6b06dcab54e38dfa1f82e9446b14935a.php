<?php $__env->startSection('title', 'إضافة موقع'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-geo-alt"></i> إضافة موقع جديد</h4>
    <a href="<?php echo e(route('locations.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>

<div class="card"><div class="card-body" style="padding:25px">
    <form action="<?php echo e(route('locations.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">اسم الموقع *</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">المنطقة</label>
                <select name="region_id" class="form-select" id="regionSelect" onchange="loadChildren(this.value)">
                    <option value="">-- بدون منطقة --</option>
                    <?php $__currentLoopData = $regions->whereNull('parent_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($region->id); ?>" <?php echo e(old('region_id')==$region->id?'selected':''); ?>><?php echo e($region->name); ?></option>
                        <?php $__currentLoopData = $regions->where('parent_id', $region->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($child->id); ?>" <?php echo e(old('region_id')==$child->id?'selected':''); ?>>&nbsp;&nbsp;&nbsp;↳ <?php echo e($child->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">النوع</label>
                <input type="text" name="type" class="form-control" value="<?php echo e(old('type')); ?>" placeholder="مثال: مخيم، فندق، قاعة">
            </div>
            <div class="col-md-4">
                <label class="form-label">المدينة</label>
                <input type="text" name="city" class="form-control" value="<?php echo e(old('city')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">السعة</label>
                <input type="number" name="capacity" class="form-control" value="<?php echo e(old('capacity')); ?>" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة</label>
                <select name="is_active" class="form-select">
                    <option value="1" <?php echo e(old('is_active','1')=='1'?'selected':''); ?>>نشط</option>
                    <option value="0" <?php echo e(old('is_active')=='0'?'selected':''); ?>>غير نشط</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">خط العرض (lat)</label>
                <input type="number" step="any" name="lat" class="form-control" value="<?php echo e(old('lat')); ?>" id="lat">
            </div>
            <div class="col-md-4">
                <label class="form-label">خط الطول (lng)</label>
                <input type="number" step="any" name="lng" class="form-control" value="<?php echo e(old('lng')); ?>" id="lng">
            </div>
            <div class="col-12">
                <label class="form-label">العنوان</label>
                <input type="text" name="address" class="form-control" value="<?php echo e(old('address')); ?>">
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes')); ?></textarea>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
            <a href="<?php echo e(route('locations.index')); ?>" class="btn btn-back">إلغاء</a>
        </div>
    </form>
</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/locations/create.blade.php ENDPATH**/ ?>