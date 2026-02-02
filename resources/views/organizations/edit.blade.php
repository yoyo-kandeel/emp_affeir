@extends('layouts.master')

@section('title','تعديل المنشأة')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4>تعديل بيانات المنشأة</h4>
                <form action="{{ route('organizations.update', $organization->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>اسم المنشأة</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $organization->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>الاسم بالإنجليزي</label>
                        <input type="text" name="english_name" class="form-control" value="{{ old('english_name', $organization->english_name) }}">
                    </div>

                    <div class="mb-3">
                        <label>الهاتف</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $organization->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $organization->email) }}">
                    </div>

                    <div class="mb-3">
                        <label>العنوان</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $organization->address) }}">
                    </div>

                    <div class="mb-3">
                        <label>الوصف</label>
                        <textarea name="description" class="form-control">{{ old('description', $organization->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>شعار المنشأة</label>
                        <input type="file" name="logo" class="form-control" onchange="previewLogo(event)">
                        <br>
                        <img id="logoPreview" src="{{ $organization->logo ? asset('storage/'.$organization->logo) : '#' }}" 
                             style="max-width:150px; display: {{ $organization->logo ? 'block' : 'none' }}">
                    </div>

                    <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                    <a href="{{ route('organizations.show', $organization->id) }}" class="btn btn-secondary">رجوع للتفاصيل</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function previewLogo(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('logoPreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
