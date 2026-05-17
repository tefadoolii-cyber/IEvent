<?php $__env->startSection('title', 'إضافة جهاز'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إضافة جهاز جديد</h4>
    <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>

<div class="card"><div class="card-body" style="padding:25px">
    <form action="<?php echo e(route('assets.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="section-title">بيانات الجهاز</div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">اسم الجهاز *</label>
                <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required placeholder="مثال: لابتوب Dell">
            </div>
            <div class="col-md-6">
                <label class="form-label">النوع</label>
                <input type="text" name="type" class="form-control" value="<?php echo e(old('type')); ?>" placeholder="مثال: لابتوب، جوال، طابعة">
            </div>
            <div class="col-md-4">
                <label class="form-label">الماركة</label>
                <input type="text" name="brand" class="form-control" value="<?php echo e(old('brand')); ?>" placeholder="مثال: Dell, HP, Samsung">
            </div>
            <div class="col-md-4">
                <label class="form-label">الموديل</label>
                <input type="text" name="model" class="form-control" value="<?php echo e(old('model')); ?>" placeholder="مثال: Latitude 5520">
            </div>
            <div class="col-md-4">
                <label class="form-label">الرقم التسلسلي</label>
                <input type="text" name="serial_number" class="form-control" value="<?php echo e(old('serial_number')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة *</label>
                <select name="status" class="form-select" required>
                    <?php $__currentLoopData = ['available'=>'متاح','maintenance'=>'صيانة','retired'=>'مُهلَك']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v); ?>" <?php echo e(old('status','available')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ الشراء</label>
                <input type="date" name="purchase_date" class="form-control" value="<?php echo e(old('purchase_date')); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">سعر الشراء (ر.س)</label>
                <input type="number" name="purchase_price" class="form-control" value="<?php echo e(old('purchase_price')); ?>" min="0" step="0.01">
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes')); ?></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
        <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-back">إلغاء</a>
    </form>
</div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/assets/create.blade.php ENDPATH**/ ?>