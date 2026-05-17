<?php $__env->startSection('title', 'إدارة الشركات'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إدارة الشركات</h4>
    <a href="<?php echo e(route('companies.create')); ?>" class="btn btn-add"><i class="bi bi-plus-lg"></i> إضافة شركة</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card mb-3"><div class="card-body" style="padding:15px">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="بحث بالاسم أو المدينة..." value="<?php echo e(request('search')); ?>"></div>
        <div class="col-md-3">
            <select name="is_active" class="form-select">
                <option value="">كل الحالات</option>
                <option value="1" <?php echo e(request('is_active')==='1'?'selected':''); ?>>نشطة</option>
                <option value="0" <?php echo e(request('is_active')==='0'?'selected':''); ?>>غير نشطة</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-save flex-fill">بحث</button>
            <a href="<?php echo e(route('companies.index')); ?>" class="btn btn-back">مسح</a>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">قائمة الشركات</span>
        <span style="color:#9ca3af;font-size:13px"><?php echo e($companies->total()); ?> شركة</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>الشركة</th><th>السجل التجاري</th><th>المسؤول</th><th>الجوال</th><th>المدينة</th><th>الحالة</th><th>الإجراء</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $co): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->iteration + ($companies->currentPage()-1)*$companies->perPage()); ?></td>
                    <td style="font-weight:600"><?php echo e($co->name); ?></td>
                    <td style="font-size:13px"><?php echo e($co->commercial_register ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($co->contact_person ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($co->phone ?? '-'); ?></td>
                    <td style="font-size:13px"><?php echo e($co->city ?? '-'); ?></td>
                    <td>
                        <?php if($co->is_active): ?> <span class="badge-active">نشطة</span>
                        <?php else: ?> <span class="badge-inactive">غير نشطة</span> <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('companies.edit', $co->id)); ?>" class="btn btn-edit"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('companies.destroy', $co->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('حذف الشركة؟')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center py-4" style="color:#9ca3af"><i class="bi bi-building" style="font-size:30px"></i><p class="mt-2">لا توجد شركات</p></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($companies->hasPages()): ?>
    <div class="card-footer" style="background:white;border-top:1px solid #f0f0f0;padding:12px 20px"><?php echo e($companies->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/companies/index.blade.php ENDPATH**/ ?>