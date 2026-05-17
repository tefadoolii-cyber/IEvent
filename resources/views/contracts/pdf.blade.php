<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="UTF-8">
<style>
    @font-face {
        font-family: 'Arial';
        font-style: normal;
    }
    * { font-family: Arial, sans-serif; box-sizing: border-box; }
    body { margin: 0; padding: 30px; color: #1a1a2e; background: white; font-size: 13px; line-height: 1.7; }
    .header { text-align: center; border-bottom: 3px solid #1a1a2e; padding-bottom: 20px; margin-bottom: 25px; }
    .header .company { font-size: 22px; font-weight: bold; color: #1a1a2e; margin-bottom: 5px; }
    .header .title { font-size: 18px; font-weight: bold; color: #374151; margin-top: 8px; }
    .header .contract-num { font-size: 13px; color: #6b7280; margin-top: 4px; }

    .badge { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; }
    .badge-signed { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
    .badge-sent { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .badge-draft { background: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; }
    .badge-cancelled { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }

    .section { margin-bottom: 22px; }
    .section-title { font-size: 13px; font-weight: bold; color: #1a1a2e; border-right: 4px solid #1a1a2e; padding-right: 10px; margin-bottom: 12px; background: #f9fafb; padding: 8px 10px 8px 0; }

    table.info-table { width: 100%; border-collapse: collapse; }
    table.info-table td { padding: 8px 10px; border: 1px solid #e5e7eb; font-size: 12px; }
    table.info-table td.label { background: #f9fafb; font-weight: bold; color: #374151; width: 35%; }

    .terms-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 15px; font-size: 12px; line-height: 1.9; white-space: pre-line; min-height: 80px; }

    .signature-section { margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    .sig-box { display: inline-block; border: 1px solid #e5e7eb; border-radius: 6px; padding: 8px; background: #fafafa; }
    .sig-box img { max-height: 90px; display: block; }
    .sig-label { font-size: 11px; color: #6b7280; margin-top: 6px; text-align: center; }
    .sig-line { border-bottom: 1px solid #374151; width: 180px; margin: 60px auto 6px; }

    .footer { text-align: center; margin-top: 40px; font-size: 10px; color: #9ca3af; border-top: 1px solid #f0f0f0; padding-top: 12px; }
    .two-col { width: 100%; }
    .two-col td { vertical-align: top; width: 50%; }
</style>
</head>
<body>

<div class="header">
    <div class="company">نظام إدارة الموارد البشرية</div>
    <div class="title">عقد عمل</div>
    <div class="contract-num">رقم العقد: {{ $contract->contract_number }}</div>
</div>

<div class="section">
    <div class="section-title">بيانات الموظف</div>
    <table class="info-table">
        <tr>
            <td class="label">الاسم الكامل</td>
            <td>{{ $contract->employee->name }}</td>
            <td class="label">رقم الموظف</td>
            <td>{{ $contract->employee->employee_number }}</td>
        </tr>
        <tr>
            <td class="label">القسم</td>
            <td>{{ $contract->employee->department ?? '-' }}</td>
            <td class="label">رقم الجوال</td>
            <td>{{ $contract->employee->phone ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">البريد الإلكتروني</td>
            <td colspan="3">{{ $contract->employee->email ?? '-' }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <div class="section-title">بيانات العقد</div>
    <table class="info-table">
        <tr>
            <td class="label">رقم العقد</td>
            <td>{{ $contract->contract_number }}</td>
            <td class="label">حالة العقد</td>
            <td>
                <span class="badge badge-{{ $contract->status }}">{{ $contract->status_label }}</span>
            </td>
        </tr>
        <tr>
            <td class="label">المسمى الوظيفي</td>
            <td>{{ $contract->position ?? '-' }}</td>
            <td class="label">الراتب الشهري</td>
            <td>{{ $contract->salary ? number_format($contract->salary, 2).' ريال سعودي' : '-' }}</td>
        </tr>
        <tr>
            <td class="label">تاريخ بداية العقد</td>
            <td>{{ $contract->start_date?->format('Y-m-d') ?? '-' }}</td>
            <td class="label">تاريخ نهاية العقد</td>
            <td>{{ $contract->end_date?->format('Y-m-d') ?? 'مفتوح' }}</td>
        </tr>
        @if($contract->signed_at)
        <tr>
            <td class="label">تاريخ التوقيع</td>
            <td colspan="3">{{ $contract->signed_at->format('Y-m-d H:i') }}</td>
        </tr>
        @endif
    </table>
</div>

@if($contract->terms)
<div class="section">
    <div class="section-title">بنود وشروط العقد</div>
    <div class="terms-box">{{ $contract->terms }}</div>
</div>
@endif

<div class="signature-section">
    <table class="two-col">
        <tr>
            <td style="text-align:center">
                <div style="font-weight:bold;font-size:12px;margin-bottom:10px">توقيع الموظف</div>
                @if($contract->signature)
                    <div class="sig-box">
                        <img src="{{ $contract->signature }}">
                    </div>
                    <div class="sig-label">{{ $contract->employee->name }}</div>
                @else
                    <div class="sig-line"></div>
                    <div class="sig-label">{{ $contract->employee->name }}</div>
                @endif
            </td>
            <td style="text-align:center">
                <div style="font-weight:bold;font-size:12px;margin-bottom:10px">توقيع صاحب العمل</div>
                <div class="sig-line"></div>
                <div class="sig-label">مدير الموارد البشرية</div>
            </td>
        </tr>
    </table>
</div>

<div class="footer">
    تم إنشاء هذا العقد بتاريخ {{ now()->format('Y-m-d') }} | نظام إدارة الموارد البشرية
</div>

</body>
</html>
