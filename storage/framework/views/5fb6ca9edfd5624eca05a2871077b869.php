

<?php $__env->startSection('title', 'إدارة المستخدمين'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إدارة المستخدمين</h4>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> إضافة مستخدم
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600; font-size:15px;">قائمة المستخدمين</span>
        <span style="color:#9ca3af; font-size:13px;">إجمالي: <?php echo e(count($users)); ?> مستخدم</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الدور</th>
                    <th>الموظف المرتبط</th>
                    <th>الإجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td style="font-weight:600"><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td>
                        <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge-active"><?php echo e($role->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td><?php echo e($user->employee->name ?? '-'); ?></td>
                    <td>
                        <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-edit">
                            <i class="bi bi-pencil"></i> تعديل
                        </a>
                        <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('هل أنت متأكد؟')">
                                <i class="bi bi-trash"></i> حذف
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-4" style="color:#9ca3af">
                        <i class="bi bi-inbox" style="font-size:30px"></i>
                        <p class="mt-2">لا يوجد مستخدمين بعد</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/users/index.blade.php ENDPATH**/ ?>