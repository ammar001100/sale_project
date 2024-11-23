@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    اضافة خزنة
@endsection
@section('pageTitle')
    اضافة خزنة
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.treasuries') }}">الخزن</a></li>
        <li class="breadcrumb-item active">اضافة</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">اضافة خزنة جديدة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('admin.treasuries.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>اسم الخزنة</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                        placeholder="ادخل اسم الخزنة">
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>نوع الخزنة</label>
                                    <select class="custom-select" name="is_master">
                                        <option @if (old('is_master') == 0) selected @else '' @endif value="0">
                                            فرعية</option>
                                        <option @if (old('is_master') == 1) selected @else '' @endif value="1">
                                            رئيسية</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>حالة التفعيل</label>
                                    <select class="custom-select" name="active">
                                        <option @if (old('active') == 1) selected @else '' @endif value="1">
                                            مفعل</option>
                                        <option @if (old('active') == 0) selected @else '' @endif value="0">
                                            غير مفعل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>اخر رقم اصال تحصيل</label>
                                    <input type="text" name="last_isal_collect" value="{{ old('last_isal_collect') }}"
                                        class="form-control" placeholder="ادخل اخر رقم اصال تحصيل ">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>اخر رقم اصال صرف</label>
                                    <input type="text" name="last_isal_exhcange" value="{{ old('last_isal_exhcange') }}"
                                        class="form-control" placeholder="ادخل اخر رقم اصال صرف ">
                                </div>
                            </div>
                        </div>
                        <div class="card_title_center">
                            <button type="submit" class="btn btn-success">اضافة</button>
                            <a href="{{ route('admin.treasuries') }}" type="button" class="btn btn-danger">الغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@section('include')
    @include('admin.partials._errors')
@endsection
@section('script')
@endsection
