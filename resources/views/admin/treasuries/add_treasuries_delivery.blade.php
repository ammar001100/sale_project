@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    اضافة خزنة مستلم منها
@endsection
@section('pageTitle')
    اضافة خزنة لتستلم منها الخزنة({{ $data->name }})
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.treasuries') }}">الخزن</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.treasuries.show', $data->id) }}">تفاصيل الخزنة
            </a></li>
        <li class="breadcrumb-item active">اضافة خزنة مستلم منها</li>
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
                    <form role="form" action="{{ route('admin.treasuries.store_treasuries_delivery', $data->id) }}"
                        method="POST">
                        @csrf
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>اختر الخزنة التي سيتم الاستلام منها</label>
                                <select class="custom-select" name="treasuries_can_delivery_id">
                                    <option value="">اختيار</option>
                                    @if (@isset($treasuries) && !@empty($treasuries))
                                        @foreach ($treasuries as $info)
                                            <option @if (old('treasuries_can_delivery_id') == $info->id) selected @else '' @endif
                                                value="{{ $info->id }}">{{ $info->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="card_title_center">
                            <button type="submit" class="btn btn-success">اضافة</button>
                            <a href="{{ route('admin.treasuries.show', $data->id) }}" type="button"
                                class="btn btn-danger">الغاء</a>
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
