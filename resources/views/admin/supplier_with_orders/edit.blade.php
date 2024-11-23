@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    تعديل فاتورة مشتريات
@endsection
@section('pageTitle')
    تعديل فاتورة مشتريات رقم ({{ $data->auto_serial }})
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">حركات مخزنية</li>
        <li class="breadcrumb-item"><a href="{{ route('supplier_orders.index') }}">فواتير المشتريات</a></li>
        <li class="breadcrumb-item active">تعديل الفاتورة رقم ({{ $data->auto_serial }})</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">تعديل فاتورة مشتريات </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('supplier_orders.update', $data->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>تاريخ الفاتورة</label>
                                    <input type="date" name="order_date"
                                        value="{{ old('order_date', $data->order_date) }}" class="form-control"
                                        placeholder="ادخل تاريخ الفاتورة">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>رقم الفاتورة بأصل المشتريات</label>
                                    <input type="text" name="doc_no" value="{{ old('doc_no', $data->doc_no) }}"
                                        class="form-control" placeholder="ادخل رقم الفاتورة المسجل بأصل المشتريات">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>بيانات المورد</label>
                                    @if (old('supplier_code', $data->supplier_id) == '' or $errors->has('supplier_code', $data->supplier_id))
                                        <b class="start_supplier_code" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="supplier_id" id="supplier_id">
                                        <option value="">اختر المورد</option>
                                        @if (@isset($supplier) && !@empty($supplier))
                                            @foreach ($supplier as $info)
                                                <option @if (old('supplier_id', $data->supplier_id) == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>بيانات المخازن</label>
                                    @if (old('store_id', $data->store_id) == '' or $errors->has('store_id', $data->store_id))
                                        <b class="start_store_id" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="store_id" id="store_id">
                                        <option value="">اختر المخزن</option>
                                        @if (@isset($stores) && !@empty($stores))
                                            @foreach ($stores as $info)
                                                <option @if (old('store_id', $data->store_id) == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>نوع الفاتورة</label>
                                    @if (old('pill_type', $data->pill_type) == '' or $errors->has('pill_type', $data->pill_type))
                                        <b class="start_pill_type" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="pill_type">
                                        <option @if (old('pill_type', $data->pill_type) == 1) selected @else '' @endif value="1">
                                            كاش</option>
                                        <option @if (old('pill_type', $data->pill_type) == 2) selected @else '' @endif value="2">
                                            أجل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>حالة التفعيل</label>
                                    <select class="custom-select" name="active">
                                        <option @if (old('active', $data->active) == 1) selected @else '' @endif value="1">
                                            مفعل</option>
                                        <option @if (old('active', $data->active) == 0 and old('active', $data->active) != '') selected @else '' @endif value="0">
                                            غير مفعل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ملاحظات</label>
                                    @if (old('notes', $data->notes) == '' or $errors->has('notes', $data->notes))
                                        <b class="start_notes" style="color: rgb(240, 43, 17);"></b>
                                    @endif
                                    <input type="text" name="notes" id="notes"
                                        value="{{ old('notes', $data->notes) }}" class="form-control"
                                        placeholder="ادخل الملاحظات">
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
