<?php $__env->startSection('title', 'إدارة الفرق'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-people-fill"></i> إدارة الفرق الميدانية</h4>
    <a href="<?php echo e(route('teams.create')); ?>" class="btn btn-add">
        <i class="bi bi-plus-lg"></i> فريق جديد
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card mb-3">
    <form method="GET" class="row g-2 align-items-end" style="padding:14px">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="بحث بالاسم..." value="<?php echo e(request('search')); ?>" style="font-size:13px">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
        </div>
        <?php if(request('search')): ?>
            <div class="col-auto"><a href="<?php echo e(route('teams.index')); ?>" class="btn btn-back" style="font-size:13px">مسح</a></div>
        <?php endif; ?>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if($teams->count()): ?>
        <table class="table mb-0">
            <thead>
                <tr><th>اسم الفريق</th><th>المشرف</th><th>المنطقة</th><th>الأعضاء</th><th>الحالة</th><th></th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-weight:600"><?php echo e($team->name); ?></td>
                    <td style="font-size:13px"><?php echo e($team->supervisor?->name ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($team->region?->name ?? '-'); ?></td>
                    <td>
                        <span style="background:#dbeafe;color:#1d4ed8;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600">
                            <?php echo e($team->members_count); ?> موظف
                        </span>
                    </td>
                    <td>
                        <span style="background:<?php echo e($team->is_active?'#dcfce7':'#fee2e2'); ?>;color:<?php echo e($team->is_active?'#16a34a':'#dc2626'); ?>;padding:3px 10px;border-radius:20px;font-size:11px">
                            <?php echo e($team->is_active ? 'نشط' : 'غير نشط'); ?>

                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('teams.show', $team->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('teams.edit', $team->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('teams.destroy', $team->id)); ?>" method="POST" onsubmit="return confirm('حذف هذا الفريق؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:14px 20px"><?php echo e($teams->withQueryString()->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-people" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد فرق</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/teams/index.blade.php ENDPATH**/ ?>