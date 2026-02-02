@extends('layouts.master')
@section('title','تعديل الملف الشخصي')

@section('css')
<!-- Internal Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"><a href="{{ route('dashboard') }}">الرئيسية</a> </h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الملف الشخصي</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
<div class="row">

    <div class="col-lg-12 col-md-12">
        @include('layouts.maseg') {{-- عرض رسائل النجاح/خطأ --}}

        <div class="card">
            <div class="card-body">

                <form class="parsley-style-1" id="profileForm" autocomplete="off"
                      action="{{ route('profile.update') }}" method="post">
                    {{ csrf_field() }}
                    @method('PATCH')

                    {{-- بيانات الملف الشخصي --}}
                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="nameWrapper">
                            <label>الاسم: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20 @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   required=""
                                   type="text">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="parsley-input col-md-6" id="emailWrapper">
                            <label>البريد الإلكتروني: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20 @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required=""
                                   type="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- إعادة إرسال التفعيل لو البريد غير مفعل --}}
                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
                        && ! auth()->user()->hasVerifiedEmail())
                        <div class="mb-3">
                            <small class="text-warning d-block mb-2">البريد الإلكتروني غير مفعل</small>
                            <button type="submit"
                                    formaction="{{ route('verification.send') }}"
                                    formmethod="POST"
                                    class="btn btn-link p-0">
                                إعادة إرسال رسالة التفعيل
                            </button>
                        </div>
                    @endif

                    {{-- تغيير كلمة المرور --}}
                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="currentPasswordWrapper"  style="display:none;">
                            <label>كلمة المرور الحالية:</label>
                            <input class="form-control form-control-sm @error('current_password') is-invalid @enderror"
                                   name="current_password" type="password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="parsley-input col-md-6" id="newPasswordWrapper">
                            <label>كلمة المرور الجديدة:</label>
                            <input class="form-control form-control-sm @error('password') is-invalid @enderror"
                                   name="password" type="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                  

                        <div class="parsley-input col-md-6" id="confirmPasswordWrapper">
                            <label>تأكيد كلمة المرور الجديدة:</label>
                            <input class="form-control form-control-sm"
                                   name="password_confirmation" type="password">
                        </div>
                      </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-main-primary pd-x-20" type="submit">حفظ التعديلات</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<!-- Internal Form-validation js -->
<script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection
