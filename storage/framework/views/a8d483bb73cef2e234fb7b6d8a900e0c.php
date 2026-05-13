

<?php $__env->startSection('title', 'إدارة الأدوار والصلاحيات'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إدارة الأدوار والصلاحيات</h4>
    <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-add">إضافة دور</a>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">قائمة الأدوار</span>
        <span style="color:#9ca3af; font-size:13px;">إجمالي: <?php echo e(count($roles)); ?> دور</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الدور</th>
                    <th>عدد الصلاحيات</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td style="font-weight:600"><?php echo e($role->name); ?></td>
                    <td><span class="badge-active"><?php echo e(count($role->permissions)); ?> صلاحية</span></td>
                    <td>
                        <a href="<?php echo e(route('roles.edit', $role->id)); ?>" class="btn btn-edit">تعديل</a>
                        <?php if(!in_array($role->name, ['admin', 'employee'])): ?>
                        <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/roles/index.blade.php ENDPATH**/ ?>