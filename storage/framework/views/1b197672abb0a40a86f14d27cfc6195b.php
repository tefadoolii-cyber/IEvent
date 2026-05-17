<?php $__env->startSection('title', 'الإشعارات'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4><i class="bi bi-bell"></i> الإشعارات</h4>
    <?php if(Auth::user()->unreadNotifications->count()): ?>
    <form action="<?php echo e(route('notifications.read-all')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-save" style="font-size:13px"><i class="bi bi-check2-all"></i> تعليم الكل كمقروء</button>
    </form>
    <?php endif; ?>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <?php if($notifications->count()): ?>
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $data = $n->data; $isRead = !is_null($n->read_at); ?>
        <div style="padding:16px 20px;border-bottom:1px solid #f0f0f0;background:<?php echo e($isRead?'white':'#f0f9ff'); ?>;display:flex;align-items:flex-start;gap:16px">
            <div style="width:40px;height:40px;background:<?php echo e($isRead?'#f3f4f6':'#dbeafe'); ?>;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <?php
                    $icons = ['expiring_contract'=>'bi-file-earmark-text','late_task'=>'bi-check2-square','new_ticket'=>'bi-headset'];
                    $colors = ['expiring_contract'=>'#d97706','late_task'=>'#dc2626','new_ticket'=>'#3b82f6'];
                    $icon  = $icons[$data['type']??'']  ?? 'bi-bell';
                    $color = $colors[$data['type']??''] ?? '#6b7280';
                ?>
                <i class="bi <?php echo e($icon); ?>" style="color:<?php echo e($color); ?>;font-size:16px"></i>
            </div>
            <div style="flex:1">
                <div style="font-weight:<?php echo e($isRead?'400':'700'); ?>;font-size:14px;color:#111827"><?php echo e($data['title'] ?? 'إشعار'); ?></div>
                <div style="font-size:13px;color:#6b7280;margin-top:2px"><?php echo e($data['message'] ?? ''); ?></div>
                <div style="font-size:11px;color:#9ca3af;margin-top:4px"><?php echo e($n->created_at->diffForHumans()); ?></div>
            </div>
            <div style="display:flex;gap:6px;align-items:center">
                <?php if(!$isRead): ?>
                <form action="<?php echo e(route('notifications.read', $n->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-edit" style="font-size:11px;padding:4px 8px" title="تعليم كمقروء"><i class="bi bi-check2"></i></button>
                </form>
                <?php endif; ?>
                <?php if(isset($data['url'])): ?>
                <a href="<?php echo e($data['url']); ?>" class="btn btn-save" style="font-size:11px;padding:4px 8px"><i class="bi bi-arrow-left"></i></a>
                <?php endif; ?>
                <form action="<?php echo e(route('notifications.destroy', $n->id)); ?>" method="POST" onsubmit="return confirm('حذف هذا الإشعار؟')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-delete" style="font-size:11px;padding:4px 8px"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div style="padding:14px 20px"><?php echo e($notifications->links()); ?></div>
        <?php else: ?>
        <div class="text-center py-5" style="color:#9ca3af">
            <i class="bi bi-bell-slash" style="font-size:36px"></i>
            <p class="mt-2 mb-0">لا توجد إشعارات</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/notifications/index.blade.php ENDPATH**/ ?>