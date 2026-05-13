

<?php $__env->startSection('title', 'التعريفات الإستعلامية'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>التعريفات الإستعلامية</h4>
    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addGroupModal">
        <i class="bi bi-plus-lg"></i> إضافة مجموعة
    </button>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-danger"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<div class="row g-3">
    <!-- قائمة المجموعات -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600">المجموعات</span>
                <span style="color:#9ca3af; font-size:13px"><?php echo e(count($groups)); ?> مجموعة</span>
            </div>
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('lookup-groups.index', ['group' => $group->key])); ?>"
                       style="display:flex; justify-content:space-between; align-items:center; padding:12px 18px; text-decoration:none; color:#1a1a2e; border-bottom:1px solid #f0f0f0; <?php echo e($selectedGroup && $selectedGroup->id == $group->id ? 'background:#f0fdf4; border-right:3px solid #4ade80;' : ''); ?>">
                        <div>
                            <div style="font-weight:600; font-size:14px"><?php echo e($group->name_ar); ?></div>
                            <div style="color:#9ca3af; font-size:12px"><?php echo e($group->key); ?></div>
                        </div>
                        <span class="badge-active"><?php echo e(count($group->lookups)); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4" style="color:#9ca3af">لا يوجد مجموعات</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- قيم المجموعة المحددة -->
    <div class="col-md-8">
        <?php if($selectedGroup): ?>
        <div class="card">
            <div class="card-header">
                <div>
                    <span style="font-weight:600"><?php echo e($selectedGroup->name_ar); ?></span>
                    <small style="color:#9ca3af">(<?php echo e($selectedGroup->key); ?>)</small>
                </div>
                <div>
                    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addLookupModal">
                        <i class="bi bi-plus-lg"></i> إضافة قيمة
                    </button>
                    <button class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#editGroupModal">
                        <i class="bi bi-pencil"></i> تعديل المجموعة
                    </button>
                    <?php if(!$selectedGroup->is_system): ?>
                    <form action="<?php echo e(route('lookup-groups.destroy', $selectedGroup->id)); ?>" method="POST" style="display:inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-delete" onclick="return confirm('متأكد من حذف المجموعة وكل قيمها؟')">
                            <i class="bi bi-trash"></i> حذف المجموعة
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>القيمة بالعربي</th>
                            <th>القيمة بالإنجليزي</th>
                            <th>الترتيب</th>
                            <th>الحالة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $selectedGroup->lookups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lookup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td style="font-weight:600"><?php echo e($lookup->value_ar); ?></td>
                            <td><?php echo e($lookup->value_en ?? '-'); ?></td>
                            <td><?php echo e($lookup->sort_order); ?></td>
                            <td>
                                <?php if($lookup->is_active): ?>
                                    <span class="badge-active">نشط</span>
                                <?php else: ?>
                                    <span class="badge-inactive">مخفي</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="<?php echo e(route('lookups.destroy', $lookup->id)); ?>" method="POST" style="display:inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-delete" onclick="return confirm('متأكد؟')">حذف</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4" style="color:#9ca3af">لا يوجد قيم بعد</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <div class="card">
            <div class="card-body text-center py-5" style="color:#9ca3af">
                <i class="bi bi-collection" style="font-size:50px"></i>
                <p class="mt-3">اختر مجموعة من اليمين أو أنشئ مجموعة جديدة</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: إضافة مجموعة -->
<div class="modal fade" id="addGroupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('lookup-groups.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">إضافة مجموعة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">المفتاح (إنجليزي) *</label>
                        <input type="text" name="key" class="form-control" placeholder="مثال: location_types" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الاسم بالعربي *</label>
                        <input type="text" name="name_ar" class="form-control" placeholder="مثال: أنواع المواقع" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الاسم بالإنجليزي</label>
                        <input type="text" name="name_en" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
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

<?php if($selectedGroup): ?>
<!-- Modal: إضافة قيمة -->
<div class="modal fade" id="addLookupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('lookups.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="group_id" value="<?php echo e($selectedGroup->id); ?>">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة قيمة لـ <?php echo e($selectedGroup->name_ar); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">القيمة بالعربي *</label>
                        <input type="text" name="value_ar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">القيمة بالإنجليزي</label>
                        <input type="text" name="value_en" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الترتيب</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
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

<!-- Modal: تعديل المجموعة -->
<div class="modal fade" id="editGroupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('lookup-groups.update', $selectedGroup->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header">
                    <h5 class="modal-title">تعديل المجموعة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الاسم بالعربي *</label>
                        <input type="text" name="name_ar" class="form-control" value="<?php echo e($selectedGroup->name_ar); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الاسم بالإنجليزي</label>
                        <input type="text" name="name_en" class="form-control" value="<?php echo e($selectedGroup->name_en); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control" rows="2"><?php echo e($selectedGroup->description); ?></textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" <?php if($selectedGroup->is_active): ?> checked <?php endif; ?>>
                        <label class="form-check-label" for="isActive">نشط</label>
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
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/lookups/index.blade.php ENDPATH**/ ?>