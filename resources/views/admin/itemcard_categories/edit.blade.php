@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    تعديل فئة صنف
@endsection
@section('pageTitle')
    تعديل فئة صنف ({{ $data->name }})
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li class="breadcrumb-item"><a href="{{ route('itemcard_categories.index') }}">فئات الاصناف</a></li>
        <li class="breadcrumb-item active">تعديل الفئة</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">ادخل بيانات فئة الصنف للتحديث</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('itemcard_categories.update', $data->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>اسم فئة الصنف</label>
                                    <input type="text" name="name"value="{{ old('name', $data['name']) }}"
                                        class="form-control" placeholder="ادخل اسم فئة الصنف">
                                </div>
                            </div>
                            <div class="col-sm-12">
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
                    <a href="{{ route('itemcard_categories.index') }}" type="button" class="btn btn-danger">الغاء</a>
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
