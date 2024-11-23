@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    اضافة خزنة للمستخدم
@endsection
@section('pageTitle')
    اضافة خزنة للمستخدم({{ $data->name }})
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">الصلاحيات</li>
        <li class="breadcrumb-item"><a href="{{ route('admin_accounts.index') }}">المستخدمين</a></li>
        <li class="breadcrumb-item active">اضافة خزنة لمستخدم</a></li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">اختيار الخزنة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('admin_accounts.store_treasury', $data->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>اختر الخزنة التي سيتم الاستلام منها</label>
                                    <select class="custom-select" name="treasury_id">
                                        <option value="">اختيار</option>
                                        @if (@isset($treasuries) && !@empty($treasuries))
                                            @foreach ($treasuries as $info)
                                                <option @if (old('treasury_id') == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
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
                            <div class="card_title_center">
                                <button type="submit" class="btn btn-success">اضافة</button>
                                <a href="{{ route('admin.treasuries.show', $data->id) }}" type="button"
                                    class="btn btn-danger">الغاء</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('include')
    @include('admin.partials._errors')
@endsection
@section('script')
@endsection
