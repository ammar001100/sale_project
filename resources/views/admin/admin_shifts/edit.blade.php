@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    تعديل الوحدة
@endsection
@section('pageTitle')
    تعديل الوحدة
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.stores') }}">الوحدات</a></li>
        <li class="breadcrumb-item active">تعديل الوحدة ({{ $data->name }})</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">ادخل بيانات الوحدة للتحديث</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('admin.uoms.update', $data->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>اسم الوحدة</label>
                                    <input type="text" name="name"value="{{ old('name', $data['name']) }}"
                                        class="form-control" placeholder="ادخل اسم الوحدة">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>نوع الوحدة</label>
                                    <select class="custom-select" name="is_master">
                                        <option @if (old('active', $data['is_master']) == 1) selected @else '' @endif value="1">
                                            وحدة اب</option>
                                        <option @if (old('active', $data['is_master']) == 0) selected @else '' @endif value="0">
                                            وحدة تجزئة
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>حالة التفعيل</label>
                                    <select class="custom-select" name="active">
                                        <option @if (old('active', $data['active']) == 1) selected @else '' @endif value="1">
                                            مفعل</option>
                                        <option @if (old('active', $data['active']) == 0) selected @else '' @endif value="0">
                                            غير
                                            مفعل</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card_title_center">
                    <button type="submit" class="btn btn-success">تحديث</button>
                    <a href="{{ route('admin.uoms') }}" type="button" class="btn btn-danger">الغاء</a>
                </div>
            </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
@section('include')
    @include('admin.partials._errors')
@endsection
@section('script')
@endsection
