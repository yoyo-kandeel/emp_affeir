<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>بطاقة الموظف</title>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: "Tahoma", "DejaVu Sans", sans-serif;
    direction: rtl;
}

/* الكارت */
.card {
    width: 85.6mm;      /* عرض الكارت الحقيقي */
    height: 53.98mm;    /* ارتفاع الكارت الحقيقي */
    border: 1.5mm solid #0d47a1; /* لون الهوية البصرية */
    border-radius: 5mm;
    padding: 3mm;
    background: #f9fafb;
    box-sizing: border-box;
}

/* الهيدر */
.header {
    background: #0d47a1;
    color: #fff;
    text-align: center;
    font-size: 12pt;
    font-weight: bold;
    padding: 2mm;
    border-radius: 3mm;
}

/* محتوى الموظف */
.content {
    display: flex;
    flex-direction: row-reverse;
    margin-top: 2mm;
    gap: 3mm;
}

.photo img {
    width: 22mm;
    height: 22mm;
    border-radius: 50%;
    border: 1pt solid #0d47a1;
    object-fit: cover;
}

.info {
    font-size: 10pt;
    line-height: 1.4;
}

.info b {
    font-weight: bold;
}

/* الأكواد */
.codes {
    display: flex;
    justify-content: space-between;
    margin-top: 2mm;
}

.barcode img {
    width: 55mm;
    height: 8mm;
}

.qr img {
    width: 15mm;
    height: 15mm;
}

/* الفوتر */
.footer {
    text-align: center;
    font-size: 7pt;
    margin-top: 1mm;
    color: #333;
}

/* للطباعة */
@media print {
    body {
        margin: 0;
    }
    .card {
        page-break-inside: avoid;
    }
}
</style>
</head>
<body>

<div class="card">

    <div class="header">بطاقة تعريف موظف</div>

    <div class="content">
        <div class="photo">
            <img src="{{ asset('uploads/employees/'.$employee->photo) }}" alt="صورة الموظف">
        </div>

        <div class="info">
            <div><b>الاسم:</b> {{ $employee->full_name }}</div>
            <div><b>الوظيفة:</b> {{ $employee->job_title }}</div>
            <div><b>رقم الموظف:</b> {{ $employee->id }}</div>
        </div>
    </div>

    <div class="codes">
        <div class="barcode">
            <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode">
        </div>
        <div class="qr">
            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
        </div>
    </div>

    <div class="footer">هذه البطاقة ملك للشركة</div>

</div>

<script>
window.onload = function() {
    window.print(); // فتح نافذة الطباعة تلقائي
}
</script>

</body>
</html>
