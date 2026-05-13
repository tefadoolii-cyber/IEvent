

<?php $__env->startSection('title', 'إدارة الإدارات'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إدارة الإدارات</h4>
    <a href="<?php echo e(route('modules.create')); ?>" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> إضافة إدارة
    </a>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php
$parentNames = [
    'hr'      => 'إدارة الموارد البشرية',
    'data'    => 'إدارة البيانات',
    'ops'     => 'إدارة التشغيل',
    'quality' => 'إدارة الجودة',
    'it'      => 'إدارة تقنية المعلومات',
];
?>

<?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card mb-3">
    <div class="card-header">
        <span style="font-weight:600; font-size:15px"><?php echo e($parentNames[$parent] ?? $parent); ?></span>
        <span style="color:#9ca3af; font-size:13px"><?php echo e(count($items)); ?> إدارة</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الأيقونة</th>
                    <th>اسم الإدارة</th>
                    <th>المفتاح</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><i class="<?php echo e($module->icon); ?>" style="font-size:18px; color:#4ade80"></i></td>
                    <td style="font-weight:600"><?php echo e($module->name); ?></td>
                    <td><code style="background:#f3f4f6; padding:2px 8px; border-radius:4px"><?php echo e($module->key); ?></code></td>
                    <td><?php echo e($module->order); ?></td>
                    <td>
                        <?php if($module->is_active): ?>
                            <span class="badge-active">نشط</span>
                        <?php else: ?>
                            <span class="badge-inactive">مخفي</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="<?php echo e(route('modules.toggle', $module->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button class="btn btn-edit" type="submit">
                                <?php if($module->is_active): ?>
                                    <i class="bi bi-eye-slash"></i> إخفاء
                                <?php else: ?>
                                    <i class="bi bi-eye"></i> إظهار
                                <?php endif; ?>
                            </button>
                        </form>
                        <a href="<?php echo e(route('modules.edit', $module->id)); ?>" class="btn btn-edit">
                            <i class="bi bi-pencil"></i> تعديل
                        </a>
                        <form action="<?php echo e(route('modules.destroy', $module->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">
                                <i class="bi bi-trash"></i> حذف
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/modules/index.blade.php ENDPATH**/ ?>