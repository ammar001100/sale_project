@extends('admin.layouts.app')
@section('css')
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
                <div class="card-body">
                    @if (isset($data) && !empty($data))
                        <form action="{{ route('admin.setting.general.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>اسم الشركة</label>
                                <input type="text" name="system_name" id="system_name" class="form-control"
                                    value="{{ $data['system_name'] }}" placeholder="ادخل اسم الشركة">
                            </div>
                            <div class="form-group">
                                <label>عنوان الشركة</label>
                                <input type="text" name="address" id="address" class="form-control"
                                    value="{{ $data['address'] }}" placeholder="ادخل عنوان الشركة">
                            </div>
                            <div class="form-group">
                                <label>هاتف الشركة</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ $data['phone'] }}" placeholder="ادخل هاتف الشركة">
                            </div>
                            <div class="form-group">
                                <label>رسالة التنبيه اعلى الشاشة للشركة</label>
                                <input type="text" name="general_alert" id="general_alert" class="form-control"
                                    value="{{ $data['general_alert'] }}" placeholder="ادخل رسالة التنبيه للشركة">
                            </div>
                            <div class="form-group">
                                <label>لوجو الشركة</label>
                                <div class="image">
                                    <img class="custom_img image-preview"
                                        src="{{ asset('assets/admin/uploads/admin_sttings_imgs') . '/' . $data['photo'] }}">
                                    <button type="button" class="btn btn-sm btn-success" id="update_image">تغير
                                        الصورة</button>
                                    <button type="button" class="btn btn-sm btn-danger" style="display: none;"
                                        id="cancel_update_image">االغاء</button>
                                </div>
                            </div>
                            <div id="old_image" style="display: none"><input type="file" name="photo" class="image"
                                    id="photo"></div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-sm btn-primary">حفظ التعديلات</button>
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
@endsection
