<?php $__env->startSection('title', 'إضافة تقييم'); ?>
<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إضافة تقييم جديد</h4>
    <a href="<?php echo e(route('evaluations.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p class="mb-0"><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="<?php echo e(route('evaluations.store')); ?>" method="POST" id="evalForm">
            <?php echo csrf_field(); ?>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">الموظف *</label>
                    <select name="employee_id" class="form-select" required>
                        <option value="">-- اختر --</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($emp->id); ?>" <?php echo e(old('employee_id')==$emp->id?'selected':''); ?>><?php echo e($emp->name); ?> — <?php echo e($emp->department ?? ''); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الفترة * <small style="color:#9ca3af">(مثال: 2026-Q1)</small></label>
                    <input type="text" name="period" class="form-control" value="<?php echo e(old('period')); ?>" placeholder="2026-Q2" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="draft"     <?php echo e(old('status','draft')=='draft'     ?'selected':''); ?>>مسودة</option>
                        <option value="submitted" <?php echo e(old('status')=='submitted' ?'selected':''); ?>>مُقدَّم</option>
                        <option value="approved"  <?php echo e(old('status')=='approved'  ?'selected':''); ?>>معتمد</option>
                    </select>
                </div>
            </div>

            
            <?php if($criteria->count()): ?>
            <div class="section-title">معايير التقييم</div>
            <div class="row g-3 mb-4" id="criteriaSection">
                <?php $__currentLoopData = $criteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $key = 'criteria_'.$cr->id; ?>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:13px"><?php echo e($cr->value_ar); ?></label>
                    <div style="display:flex;align-items:center;gap:10px">
                        <input type="range" name="criteria[<?php echo e($cr->id); ?>][score]" min="0" max="100" value="<?php echo e(old('criteria.'.$cr->id.'.score', 0)); ?>"
                               class="form-range" oninput="updateScore(this)">
                        <span id="score_<?php echo e($cr->id); ?>" style="font-weight:700;min-width:36px;text-align:center"><?php echo e(old('criteria.'.$cr->id.'.score', 0)); ?></span>
                        <input type="hidden" name="criteria[<?php echo e($cr->id); ?>][label]" value="<?php echo e($cr->value_ar); ?>">
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">الدرجة الإجمالية (0-100) *</label>
                    <input type="number" name="total_score" id="totalScore" class="form-control" value="<?php echo e(old('total_score', 0)); ?>" min="0" max="100" required>
                </div>
                <div class="col-12">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> حفظ</button>
                <a href="<?php echo e(route('evaluations.index')); ?>" class="btn btn-back">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<script>
function updateScore(input) {
    const id = input.name.match(/\[(\d+)\]/)[1];
    document.getElementById('score_' + id).textContent = input.value;
    // Auto-calc average of all criteria into total
    const ranges = document.querySelectorAll('[name^="criteria["]');
    if (ranges.length) {
        let sum = 0;
        ranges.forEach(r => { if(r.name.includes('[score]')) sum += parseInt(r.value); });
        document.getElementById('totalScore').value = Math.round(sum / ranges.length * 2);
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/evaluations/create.blade.php ENDPATH**/ ?>