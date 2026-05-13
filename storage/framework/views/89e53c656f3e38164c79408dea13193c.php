

<?php $__env->startSection('title', 'إضافة حقل مخصص'); ?>

<?php $__env->startSection('content'); ?>

<div class="top-header">
    <h4>إضافة حقل مخصص جديد</h4>
    <a href="<?php echo e(route('custom-fields.index')); ?>" class="btn btn-back">رجوع</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p class="mb-0"><?php echo e($error); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body" style="padding:25px">
        <form action="<?php echo e(route('custom-fields.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">الجدول *</label>
                    <select name="table_name" class="form-select" required>
                        <option value="">-- اختر --</option>
                        <option value="employees">الموظفين</option>
                        <option value="attendance">الحضور</option>
                        <option value="contracts">العقود</option>
                        <option value="companies">الشركات</option>
                        <option value="locations">المواقع</option>
                        <option value="tasks">المهام</option>
                        <option value="visits">الزيارات</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">نوع الحقل *</label>
                    <select name="field_type" class="form-select" required onchange="toggleOptions(this)">
                        <option value="">-- اختر --</option>
                        <option value="text">نص</option>
                        <option value="number">رقم</option>
                        <option value="date">تاريخ</option>
                        <option value="select">قائمة منسدلة</option>
                        <option value="textarea">نص طويل</option>
                        <option value="email">بريد إلكتروني</option>
                        <option value="phone">جوال</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">اسم العرض *</label>
                    <input type="text" name="field_label" class="form-control" placeholder="مثال: رقم الهوية" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">المفتاح (إنجليزي) *</label>
                    <input type="text" name="field_key" class="form-control" placeholder="مثال: id_number" required>
                </div>
                <div class="col-md-12" id="optionsField" style="display:none">
                    <label class="form-label">الخيارات (افصل بفاصلة)</label>
                    <input type="text" name="options" class="form-control" placeholder="مثال: نشط,غير نشط,معلق">
                </div>
                <div class="col-md-6">
                    <label class="form-label">الترتيب</label>
                    <input type="number" name="order" class="form-control" value="1">
                </div>
                <div class="col-md-6">
                    <label class="form-label">إلزامي؟</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_required" value="1" class="form-check-input" id="isRequired">
                        <label class="form-check-label" for="isRequired">نعم، الحقل إلزامي</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-save">حفظ</button>
            <a href="<?php echo e(route('custom-fields.index')); ?>" class="btn btn-back">إلغاء</a>
        </form>
    </div>
</div>

<script>
function toggleOptions(el) {
    document.getElementById('optionsField').style.display = (el.value === 'select') ? 'block' : 'none';
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\course laravel\example-app\resources\views/custom_fields/create.blade.php ENDPATH**/ ?>