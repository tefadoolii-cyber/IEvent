

<?php $__env->startSection('title', 'تعديل دور'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>تعديل الدور: <?php echo e($role->name); ?></h4>
    <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-back">
        <i class="bi bi-arrow-right"></i> رجوع
    </a>
</div>

<?php if($errors->any()): ?>
    <div class="alert alert-danger mb-3">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p class="mb-0"><?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="<?php echo e(route('roles.update', $role->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="section-title">معلومات الدور</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">اسم الدور *</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($role->name); ?>" required <?php if(in_array($role->name, ['admin', 'employee'])): ?> readonly <?php endif; ?>>
                </div>
            </div>

            <div class="section-title">الصلاحيات</div>
            <div class="row g-3">
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $modulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6">
                    <div class="card" style="background:#f9fafb; border:1px solid #e5e7eb">
                        <div class="card-body" style="padding:15px">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0" style="font-weight:600"><?php echo e($module); ?></h6>
                                <div>
                                    <input type="checkbox" onchange="toggleAll(this, '<?php echo e($module); ?>')" class="form-check-input">
                                    <small>الكل</small>
                                </div>
                            </div>
                            <?php $__currentLoopData = $modulePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check mb-2">
                                <input type="checkbox" name="permissions[]" value="<?php echo e($permission->name); ?>" id="p_<?php echo e($permission->id); ?>" class="form-check-input perm-<?php echo e($module); ?>" <?php if(in_array($permission->name, $rolePermissions)): ?> checked <?php endif; ?>>
                                <label class="form-check-label" for="p_<?php echo e($permission->id); ?>">
                                    <?php echo e($permission->name); ?>

                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-check-lg"></i> حفظ التعديل
                </button>
                <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleAll(checkbox, module) {
    document.querySelectorAll('.perm-' + module).forEach(function(item) {
        item.checked = checkbox.checked;
    });
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/roles/edit.blade.php ENDPATH**/ ?>