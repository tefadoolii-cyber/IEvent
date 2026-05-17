<?php $__env->startSection('title', 'الدعم الفني'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>تذاكر الدعم الفني</h4>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>


<div class="row g-3 mb-4">
    <?php $__currentLoopData = ['open'=>['مفتوحة','#dc2626','#fee2e2','bi-envelope-open'],'in_progress'=>['قيد المعالجة','#d97706','#fef3c7','bi-tools'],'resolved'=>['محلولة','#16a34a','#dcfce7','bi-check-circle'],'total'=>['إجمالي','#1a1a2e','#f3f4f6','bi-collection']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>[$label,$color,$bg,$icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-3 col-6">
        <div class="card text-center" style="padding:15px">
            <div style="font-size:24px;color:<?php echo e($color); ?>"><i class="bi <?php echo e($icon); ?>"></i></div>
            <div style="font-size:24px;font-weight:800;color:#1a1a2e"><?php echo e($stats[$key]); ?></div>
            <div style="color:#6b7280;font-size:13px"><?php echo e($label); ?></div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="card mb-3"><div class="card-body" style="padding:15px">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="بحث بالعنوان..." value="<?php echo e(request('search')); ?>"></div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">كل الحالات</option>
                <?php $__currentLoopData = ['open'=>'مفتوحة','in_progress'=>'قيد المعالجة','resolved'=>'محلولة','closed'=>'مغلقة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($v); ?>" <?php echo e(request('status')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="priority" class="form-select">
                <option value="">كل الأولويات</option>
                <?php $__currentLoopData = ['low'=>'منخفضة','medium'=>'متوسطة','high'=>'عالية','urgent'=>'عاجلة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($v); ?>" <?php echo e(request('priority')==$v?'selected':''); ?>><?php echo e($l); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-save flex-fill">بحث</button>
            <a href="<?php echo e(route('support-tickets.index')); ?>" class="btn btn-back">مسح</a>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600">التذاكر</span>
        <span style="color:#9ca3af;font-size:13px"><?php echo e($tickets->total()); ?> تذكرة</span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr><th>#</th><th>العنوان</th><th>المستخدم</th><th>الأولوية</th><th>الحالة</th><th>التاريخ</th><th>الإجراء</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $pColors = ['low'=>'#6b7280','medium'=>'#d97706','high'=>'#dc2626','urgent'=>'#7c3aed'];
                    $pBgs    = ['low'=>'#f3f4f6','medium'=>'#fef3c7','high'=>'#fee2e2','urgent'=>'#ede9fe'];
                    $sColors = ['open'=>'#dc2626','in_progress'=>'#d97706','resolved'=>'#16a34a','closed'=>'#6b7280'];
                    $sBgs    = ['open'=>'#fee2e2','in_progress'=>'#fef3c7','resolved'=>'#dcfce7','closed'=>'#f3f4f6'];
                ?>
                <tr>
                    <td><?php echo e($ticket->id); ?></td>
                    <td style="font-weight:600;max-width:250px"><?php echo e(Str::limit($ticket->title,50)); ?></td>
                    <td style="font-size:13px"><?php echo e($ticket->user->name ?? '-'); ?></td>
                    <td><span style="background:<?php echo e($pBgs[$ticket->priority]??'#f3f4f6'); ?>;color:<?php echo e($pColors[$ticket->priority]??'#6b7280'); ?>;padding:3px 9px;border-radius:20px;font-size:11px"><?php echo e($ticket->priority_label); ?></span></td>
                    <td><span style="background:<?php echo e($sBgs[$ticket->status]??'#f3f4f6'); ?>;color:<?php echo e($sColors[$ticket->status]??'#6b7280'); ?>;padding:3px 9px;border-radius:20px;font-size:11px"><?php echo e($ticket->status_label); ?></span></td>
                    <td style="font-size:12px"><?php echo e($ticket->created_at->format('Y-m-d')); ?></td>
                    <td>
                        <a href="<?php echo e(route('support-tickets.show', $ticket->id)); ?>" class="btn btn-edit"><i class="bi bi-eye"></i> عرض</a>
                        <form action="<?php echo e(route('support-tickets.destroy', $ticket->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-delete" onclick="return confirm('حذف التذكرة؟')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center py-4" style="color:#9ca3af"><i class="bi bi-headset" style="font-size:30px"></i><p class="mt-2">لا توجد تذاكر</p></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($tickets->hasPages()): ?>
    <div class="card-footer" style="background:white;border-top:1px solid #f0f0f0;padding:12px 20px"><?php echo e($tickets->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/support_tickets/index.blade.php ENDPATH**/ ?>