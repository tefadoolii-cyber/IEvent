<?php $__env->startSection('title', 'سجل الاعتمادات'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-patch-check"></i> سجل الاعتمادات</h4>
</div>

<div class="card">
    <div class="card-body p-0">
        <?php if($approvals->count()): ?>
        <table class="table mb-0">
            <thead>
                <tr><th>النوع</th><th>المعتمِد</th><th>الحالة</th><th>السبب / الملاحظة</th><th>التاريخ</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $approvals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div style="font-size:12px;color:#6b7280"><?php echo e(class_basename($appr->model_type)); ?></div>
                        <div style="font-size:11px;color:#9ca3af;font-family:monospace">#<?php echo e($appr->model_id); ?></div>
                    </td>
                    <td style="font-size:13px"><?php echo e($appr->approver->name); ?></td>
                    <td>
                        <span style="background:<?php echo e($appr->status==='approved'?'#dcfce7':'#fee2e2'); ?>;color:<?php echo e($appr->status==='approved'?'#16a34a':'#dc2626'); ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            <?php echo e($appr->status==='approved' ? 'معتمد' : 'مسحوب'); ?>

                        </span>
                    </td>
                    <td style="font-size:12px;color:#6b7280"><?php echo e(Str::limit($appr->reason, 60) ?? '-'); ?></td>
                    <td style="font-size:12px;color:#9ca3af"><?php echo e($appr->approved_at?->format('Y-m-d H:i') ?? $appr->created_at->format('Y-m-d H:i')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:14px 20px"><?php echo e($approvals->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-patch-check" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد اعتمادات</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/approvals/index.blade.php ENDPATH**/ ?>