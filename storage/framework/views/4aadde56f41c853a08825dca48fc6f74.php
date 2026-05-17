<?php $__env->startSection('title', 'إدارة المناطق'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-map"></i> إدارة المناطق</h4>
    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-lg"></i> منطقة جديدة
    </button>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card">
    <div class="card-body" style="padding:14px">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="بحث بالاسم..." value="<?php echo e(request('search')); ?>" style="font-size:13px">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-search"></i> بحث</button>
            </div>
            <?php if(request('search')): ?>
            <div class="col-auto">
                <a href="<?php echo e(route('regions.index')); ?>" class="btn btn-back" style="font-size:13px">مسح</a>
            </div>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body p-0">
        <?php if($regions->count()): ?>
        <table class="table mb-0">
            <thead>
                <tr><th>اسم المنطقة</th><th>المنطقة الأم</th><th>المواقع</th><th>الملاحظات</th><th>الحالة</th><th></th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-weight:600"><?php echo e($region->name); ?></td>
                    <td style="font-size:13px"><?php echo e($region->parent?->name ?? '—'); ?></td>
                    <td style="text-align:center">
                        <a href="<?php echo e(route('regions.show', $region->id)); ?>" style="color:#1d4ed8;font-weight:700;text-decoration:none"><?php echo e($region->locations_count); ?></a>
                    </td>
                    <td style="font-size:12px;color:#9ca3af"><?php echo e(Str::limit($region->notes, 40) ?? '—'); ?></td>
                    <td>
                        <span style="background:<?php echo e($region->is_active?'#dcfce7':'#fee2e2'); ?>;color:<?php echo e($region->is_active?'#16a34a':'#dc2626'); ?>;padding:3px 10px;border-radius:20px;font-size:11px">
                            <?php echo e($region->is_active ? 'نشط' : 'غير نشط'); ?>

                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <a href="<?php echo e(route('regions.show', $region->id)); ?>" class="btn btn-edit" style="font-size:11px;padding:4px 8px"><i class="bi bi-eye"></i></a>
                            <button class="btn btn-edit" style="font-size:11px;padding:4px 8px"
                                onclick="editRegion(<?php echo e($region->id); ?>,'<?php echo e(addslashes($region->name)); ?>','<?php echo e($region->parent_id); ?>','<?php echo e(addslashes($region->notes ?? '')); ?>')">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="<?php echo e(route('regions.destroy', $region->id)); ?>" method="POST" onsubmit="return confirm('حذف هذه المنطقة؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:14px 20px"><?php echo e($regions->withQueryString()->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-map" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد مناطق</p>
        </div>
        <?php endif; ?>
    </div>
</div>


<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">إضافة منطقة</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form action="<?php echo e(route('regions.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الاسم *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">المنطقة الأم</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- لا يوجد --</option>
                            <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->id); ?>"><?php echo e($p->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-save">حفظ</button>
                    <button type="button" class="btn btn-back" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">تعديل منطقة</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form id="editForm" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الاسم *</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">المنطقة الأم</label>
                        <select name="parent_id" id="editParent" class="form-select">
                            <option value="">-- لا يوجد --</option>
                            <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->id); ?>"><?php echo e($p->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" id="editNotes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-save">حفظ</button>
                    <button type="button" class="btn btn-back" data-bs-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editRegion(id, name, parentId, notes) {
    document.getElementById('editForm').action = '/regions/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editNotes').value = notes;
    document.getElementById('editParent').value = parentId || '';
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/regions/index.blade.php ENDPATH**/ ?>