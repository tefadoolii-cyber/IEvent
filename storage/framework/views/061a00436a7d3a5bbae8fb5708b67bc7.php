<?php $__env->startSection('title', 'إدارة المواقع'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-geo-alt"></i> إدارة المواقع</h4>
    <a href="<?php echo e(route('locations.create')); ?>" class="btn btn-add"><i class="bi bi-plus-lg"></i> إضافة موقع</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card mb-3"><div class="card-body" style="padding:15px">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="بحث بالاسم أو المدينة..." value="<?php echo e(request('search')); ?>" style="font-size:13px">
        </div>
        <div class="col-md-3">
            <select name="region_id" class="form-select" style="font-size:13px">
                <option value="">كل المناطق</option>
                <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($r->id); ?>" <?php echo e(request('region_id')==$r->id?'selected':''); ?>><?php echo e($r->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="is_active" class="form-select" style="font-size:13px">
                <option value="">كل الحالات</option>
                <option value="1" <?php echo e(request('is_active')==='1'?'selected':''); ?>>نشط</option>
                <option value="0" <?php echo e(request('is_active')==='0'?'selected':''); ?>>غير نشط</option>
            </select>
        </div>
        <div class="col-auto d-flex gap-2">
            <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
            <?php if(request()->hasAny(['search','region_id','is_active'])): ?>
            <a href="<?php echo e(route('locations.index')); ?>" class="btn btn-back" style="font-size:13px">مسح</a>
            <?php endif; ?>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">قائمة المواقع</span>
        <span style="color:#9ca3af;font-size:13px"><?php echo e($locations->total()); ?> موقع</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0" style="min-width:650px">
            <thead>
                <tr><th>#</th><th>الموقع</th><th>المنطقة</th><th>النوع</th><th>المدينة</th><th>الحالة</th><th>الإجراء</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="color:#9ca3af;font-size:12px"><?php echo e($loop->iteration + ($locations->currentPage()-1)*$locations->perPage()); ?></td>
                    <td>
                        <div style="font-weight:600;font-size:13px"><?php echo e($loc->name); ?></div>
                        <?php if($loc->address): ?>
                        <div style="font-size:11px;color:#9ca3af"><?php echo e(Str::limit($loc->address,40)); ?></div>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:13px">
                        <?php if($loc->region): ?>
                            <span style="background:#eff6ff;color:#1d4ed8;padding:2px 8px;border-radius:10px;font-size:11px"><?php echo e($loc->region->name); ?></span>
                        <?php else: ?>
                            <span style="color:#9ca3af">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:13px"><?php echo e($loc->type ?? '—'); ?></td>
                    <td style="font-size:13px"><?php echo e($loc->city ?? '—'); ?></td>
                    <td>
                        <?php if($loc->is_active): ?>
                            <span class="badge-active">نشط</span>
                        <?php else: ?>
                            <span class="badge-inactive">غير نشط</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('locations.show', $loc->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('locations.edit', $loc->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('locations.destroy', $loc->id)); ?>" method="POST" style="display:inline" onsubmit="return confirm('حذف الموقع؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center py-4" style="color:#9ca3af"><i class="bi bi-geo-alt" style="font-size:30px"></i><p class="mt-2 mb-0">لا توجد مواقع</p></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
    <?php if($locations->hasPages()): ?>
    <div class="card-footer" style="background:white;border-top:1px solid #f0f0f0;padding:12px 20px"><?php echo e($locations->withQueryString()->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/locations/index.blade.php ENDPATH**/ ?>