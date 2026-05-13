<?php $__env->startSection('title', 'الرئيسية'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>الرئيسية</h4>
</div>

<div class="card">
    <div class="card-body" style="padding:30px">
        <h5>مرحباً بك، <?php echo e(Auth::user()->name); ?> 👋</h5>
        <p style="color:#6b7280">أنت مسجل الدخول إلى منصة iEvent</p>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/dashboard.blade.php ENDPATH**/ ?>