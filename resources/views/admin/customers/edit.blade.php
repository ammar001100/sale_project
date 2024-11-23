@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    تعديل عميل
@endsection
@section('pageTitle')
    تعديل عميل
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">الحسابات المالية</li>
        <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">العملاء</a></li>
        <li class="breadcrumb-item active">تعديل</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">تعديل عميل</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('customers.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>اسم العميل</label>
                                    @if (old('name', $data->name) == '' or $errors->has('name', $data->name))
                                        <b class="start_name" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $data->name) }}" class="form-control"
                                        placeholder="ادخل اسم العميل">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>حالة الرصيد اول المدة</label>
                                    @if (old('start_balance_status', $data->start_balance_status) == '' or
                                            $errors->has('start_balance_status', $data->start_balance_status))
                                        <b class="start_start_balance_status" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="start_balance_status" id="start_balance_status"
                                        disabled>
                                        <option value="">
                                            اختر الحالة
                                        </option>
                                        <option @if (old('start_balance_status', $data->start_balance_status) == '2') selected  @else  '' @endif value="2">
                                            مدين
                                        </option>
                                        <option @if (old('start_balance_status', $data->start_balance_status) == '1') selected  @else  '' @endif value="1">
                                            دائن
                                        </option>
                                        <option @if (old('start_balance_status', $data->start_balance_status) == '3' and
                                                (old('start_balance_status', $data->start_balance_status) == '3') != '') selected  @else '' @endif value="3">
                                            متزن
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>رصيد اول مدة</label>
                                    @if (old('start_balance', $data->start_balance) == '' and
                                            old('start_balance_status', $data->start_balance_status) != '3' or
                                            $errors->has('start_balance', $data->start_balance))
                                        <b class="start_start_balance" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <div class="start_balanceDiv1"
                                        @if (old('start_balance_status', $data->start_balance_status) != 3) '' @else style="display: none;" @endif>
                                        <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                            name="start_balance" id="start_balance"
                                            value="{{ old('start_balance', $data->start_balance) }}" class="form-control"
                                            placeholder="ادخل المبلغ بدون سالب" disabled>
                                    </div>
                                    <div class="start_balanceDiv2"
                                        @if (old('start_balance_status', $data->start_balance_status) == 3) '' @else style="display: none;" @endif>
                                        <input name="start_balance" class="form-control" value="0.00" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>العنوان</label>
                                    @if (old('address', $data->address) == '' or $errors->has('address', $data->address))
                                        <b class="start_address" style="color: rgb(240, 43, 17);"></b>
                                    @endif
                                    <input type="address" name="address" id="address"
                                        value="{{ old('address', $data->address) }}" class="form-control"
                                        placeholder="ادخل عنوان العميل">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>رقم الهاتف</label>
                                    @if (old('phone', $data->phone) == '' or $errors->has('phone', $data->phone))
                                        <b class="start_phone" style="color: rgb(240, 43, 17);"></b>
                                    @endif
                                    <input type="text" name="phone" id="phone"
                                        value="{{ old('phone', $data->phone) }}" class="form-control"
                                        placeholder="ادخل رقم هاتف العميل">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>حالة التفعيل</label>
                                    @if (old('active', $data->active) == '' or $errors->has('active', $data->active))
                                        <b class="start_active" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="active" id="active">
                                        <option value="">
                                            اختر الحالة
                                        </option>
                                        <option @if (old('active', $data->active) == '1') selected  @else  '' @endif
                                            value="1">
                                            مفعل
                                        </option>
                                        <option @if (old('active', $data->active) == '0' and (old('active', $data->active) == '0') != '') selected  @else '' @endif value="0">
                                            معطل
                                        </option>
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
                            <div class="col-sm-12" style="border: solid 1px #9290e7;margin: 10px;background: #f0f0f3;">
                                <div class="form-group">
                                    <img src="{{ asset('assets/admin/uploads/customers_imgs/' . $data->photo) }}"
                                        style="width: 100px" class="img-thumbnail image-preview" alt="">
                                </div>
                                <div class="form-group">
                                    <label>صورة العميل</label>
                                    <input type="file" name="photo" class="form-control image">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card_title_center">
                    <button id="do_add_customers" type="submit" class="btn btn-success">تحديث</button>
                    <a href="{{ route('customers.index') }}" type="button" class="btn btn-danger">الغاء</a>
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
    <script>
        var name = $("#uom_id option:selected").text();
        if (name != '') {
            $('.parent_uom_name').text(name);
        }
        var name = $("#retail_uom_id option:selected").text();
        if (name != '') {
            $('.child_uom_name').text(name);
        }
    </script>
    <script src="{{ URL::asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/customers_validation.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/customers.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/image_preview.js') }}"></script>
@endsection
