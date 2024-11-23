@extends('admin.layouts.app')
@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('headTitle')
تعديل الضبط العام
@endsection
@section('pageTitle')
تعديل الضبط العام
@endsection
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الريئسية</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.setting.general') }}">الضبط العام</a></li>
    <li class="breadcrumb-item active">تعديل</li>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card_header_style">
                <h3 class="card-title card_title_center">بيانات الشركة</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body card_body_style">
                @if (isset($data) && !empty($data))
                <form action="{{ route('admin.setting.general.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>اسم الشركة</label>
                                <input type="text" name="system_name" id="system_name" class="form-control card_body_style" value="{{ $data['system_name'] }}" placeholder="ادخل اسم الشركة">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>عنوان الشركة</label>
                                <input type="text" name="address" id="address" class="form-control card_body_style" value="{{ $data['address'] }}" placeholder="ادخل عنوان الشركة">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>هاتف الشركة</label>
                                <input type="text" name="phone" id="phone" class="form-control card_body_style" value="{{ $data['phone'] }}" placeholder="ادخل هاتف الشركة">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>رسالة التنبيه اعلى الشاشة للشركة</label>
                                <input type="text" name="general_alert" id="general_alert" class="form-control card_body_style" value="{{ $data['general_alert'] }}" placeholder="ادخل رسالة التنبيه للشركة">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>الحساب الرئيسي للعملاء في الشجرة المحاسبية</label>
                                @if (old('customer_parent_account_id', $data->customer_parent_account_id) == '' or
                                $errors->has('customer_parent_account_id', $data->customer_parent_account_id))
                                <b class="start_account" style="color: rgb(240, 43, 17);"></b>
                                @endif
                                <select class="custom-select select2 card_body_style" name="customer_parent_account_id" id="customer_parent_account_id">
                                    <option value="">اختر الحساب الذي يتبع له</option>
                                    @if (@isset($parent_account) && !@empty($parent_account))
                                    @foreach ($parent_account as $info)
                                    <option @if (old('customer_parent_account_id', $data->customer_parent_account_id) == $info->id) selected @else '' @endif
                                        value="{{ $info->id }}">{{ $info->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>الحساب الرئيسي للموردين في الشجرة المحاسبية</label>
                                @if (old('supplier_parent_account_id', $data->supplier_parent_account_id) == '' or
                                $errors->has('supplier_parent_account_id', $data->supplier_parent_account_id))
                                <b class="start_account" style="color: rgb(240, 43, 17);"></b>
                                @endif
                                <select class="custom-select select2 card_body_style" name="supplier_parent_account_id" id="supplier_parent_account_id">
                                    <option value="">اختر الحساب الذي يتبع له</option>
                                    @if (@isset($parent_account) && !@empty($parent_account))
                                    @foreach ($parent_account as $info)
                                    <option @if (old('supplier_parent_account_id', $data->supplier_parent_account_id) == $info->id) selected @else '' @endif
                                        value="{{ $info->id }}">{{ $info->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>الحساب الرئيسي للمناديب في الشجرة المحاسبية</label>
                                @if (old('delegate_parent_account_id', $data->delegate_parent_account_id) == '' or
                                $errors->has('delegate_parent_account_id', $data->delegate_parent_account_id))
                                <b class="start_account" style="color: rgb(240, 43, 17);"></b>
                                @endif
                                <select class="custom-select select2 card_body_style" name="delegate_parent_account_id" id="delegate_parent_account_id">
                                    <option value="">اختر الحساب الذي يتبع له</option>
                                    @if (@isset($parent_account) && !@empty($parent_account))
                                    @foreach ($parent_account as $info)
                                    <option @if (old('delegate_parent_account_id', $data->delegate_parent_account_id) == $info->id) selected @else '' @endif
                                        value="{{ $info->id }}">{{ $info->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>الحساب الرئيسي للموظفين في الشجرة المحاسبية</label>
                                @if (old('employee_parent_account_id', $data->employee_parent_account_id) == '' or
                                $errors->has('employee_parent_account_id', $data->employee_parent_account_id))
                                <b class="start_account" style="color: rgb(240, 43, 17);"></b>
                                @endif
                                <select class="custom-select select2 card_body_style" name="employee_parent_account_id" id="employee_parent_account_id">
                                    <option value="">اختر الحساب الذي يتبع له</option>
                                    @if (@isset($parent_account) && !@empty($parent_account))
                                    @foreach ($parent_account as $info)
                                    <option @if (old('employee_parent_account_id', $data->employee_parent_account_id) == $info->id) selected @else '' @endif
                                        value="{{ $info->id }}">{{ $info->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>لوجو الشركة</label>
                                <div class="image">
                                    <img class="custom_img image-preview" src="{{ asset('assets/admin/uploads/admin_sttings_imgs') . '/' . $data['photo'] }}">
                                    <button type="button" class="btn btn-sm btn-success card_button_style" id="update_image">تغير
                                        الصورة</button>
                                    <button type="button" class="btn btn-sm btn-danger card_button_style" style="display: none;" id="cancel_update_image">االغاء</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" id="old_image" style="display: none">
                                <input type="file" name="photo" class="image" id="photo">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-sm btn-primary card_button_style">تحديث</button>
                            </div>
                        </div>
                </form>
                @else
                <div class="alert aleart-denger">
                    عفوا لاتوجد بيانات
                </div>
                @endif

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
@section('include')
@include('admin.partials._errors')
@endsection
@section('script')
<script src="{{ URL::asset('assets/admin/js/general.js') }}"></script>
<script src="{{ URL::asset('assets/admin/js/image_preview.js') }}"></script>
<!-- Select2 -->
<script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

</script>
@endsection
