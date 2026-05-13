

<?php $__env->startSection('title', 'الحقول المخصصة'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>الحقول المخصصة</h4>
    <a href="<?php echo e(route('custom-fields.create')); ?>" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> إضافة حقل جديد
    </a>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php
$tableNames = [
    'employees'    => 'الموظفين',
    'attendance'   => 'الحضور',
    'contracts'    => 'العقود',
    'companies'    => 'الشركات',
    'locations'    => 'المواقع',
    'tasks'        => 'المهام',
    'visits'       => 'الزيارات',
];
$fieldTypes = [
    'text'     => 'نص',
    'number'   => 'رقم',
    'date'     => 'تاريخ',
    'select'   => 'قائمة منسدلة',
    'textarea' => 'نص طويل',
    'email'    => 'بريد إلكتروني',
    'phone'    => 'جوال',
];
?>

<?php $__empty_1 = true; $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tableName => $tableFields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="card mb-3">
    <div class="card-header">
        <span style="font-weight:600; font-size:15px"><?php echo e($tableNames[$tableName] ?? $tableName); ?></span>
        <span style="color:#9ca3af; font-size:13px"><?php echo e(count($tableFields)); ?> حقل</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الحقل</th>
                    <th>المفتاح</th>
                    <th>النوع</th>
                    <th>إلزامي</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $tableFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td style="font-weight:600"><?php echo e($field->field_label); ?></td>
                    <td><code style="background:#f3f4f6; padding:2px 8px; border-radius:4px"><?php echo e($field->field_key); ?></code></td>
                    <td><?php echo e($fieldTypes[$field->field_type] ?? $field->field_type); ?></td>
                    <td>
                        <?php if($field->is_required): ?>
                            <span class="badge-active">إلزامي</span>
                        <?php else: ?>
                            <span class="badge-inactive">اختياري</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('custom-fields.edit', $field->id)); ?>" class="btn btn-edit">تعديل</a>
                        <form action="<?php echo e(route('custom-fields.destroy', $field->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="card">
    <div class="card-body text-center py-5" style="color:#9ca3af">
        <i class="bi bi-plus-square" style="font-size:50px"></i>
        <p class="mt-3">لا يوجد حقول مخصصة بعد</p>
        <a href="<?php echo e(route('custom-fields.create')); ?>" class="btn btn-add">إضافة أول حقل</a>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/custom_fields/index.blade.php ENDPATH**/ ?>