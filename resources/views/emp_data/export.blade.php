               <form action="{{ route('emp_data.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>اختر ملف Excel</label>
        <input type="file" name="file" class="form-control" accept=".xlsx,.xls">
    </div>
    <button type="submit" class="btn btn-success mt-2">استيراد البيانات</button>
</form>