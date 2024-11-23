@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    اضافة فئة موردين
@endsection
@section('pageTitle')
    اضافة فئة موردين
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">الحسابات المالية</li>
        <li class="breadcrumb-item"><a href="{{ route('supplier_categories.index') }}">فئة الموردين</a></li>
        <li class="breadcrumb-item active">اضافة</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">اضافة فئة موردين جديدة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('supplier_categories.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>اسم الفئة</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                        placeholder="ادخل اسم فئة الموردين">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>حالة التفعيل</label>
                                    <select class="custom-select" name="active">
                                        <option @if (old('active') == 1) selected @else '' @endif value="1">
                                            مفعل</option>
                                        <option @if (old('active') == 0 and old('active') != '') selected @else '' @endif value="0">
                                            غير مفعل</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card_title_center">
                    <button type="submit" class="btn btn-success">اضافة</button>
                    <a href="{{ route('admin.sales_matrial_types') }}" type="button" class="btn btn-danger">الغاء</a>
                </div>
            </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
    <!-- /.col -->
    </div>
@endsection
@section('include')
    @include('admin.partials._errors')
@endsection
@section('script')
@endsection
