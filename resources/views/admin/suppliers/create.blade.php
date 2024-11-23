@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    اضافة مورد
@endsection
@section('pageTitle')
    اضافة مورد
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">الحسابات المالية</li>
        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">الموردين</a></li>
        <li class="breadcrumb-item active">اضافة</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">اضافة مورد جديدة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('suppliers.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>اسم المورد</label>
                                    @if (old('name') == '' or $errors->has('name'))
                                        <b class="start_name" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="form-control" placeholder="ادخل اسم المورد">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>فئة المورد</label>
                                    @if (old('supplier_category_id') == '' or $errors->has('supplier_category_id'))
                                        <b class="start_supplier_category_id" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="supplier_category_id" id="supplier_category_id">
                                        <option value="">اختر الفئة</option>
                                        @if (@isset($supplier_category) && !@empty($supplier_category))
                                            @foreach ($supplier_category as $info)
                                                <option @if (old('supplier_category_id') == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>حالة الرصيد اول المدة</label>
                                    @if (old('start_balance_status') == '' or $errors->has('start_balance_status'))
                                        <b class="start_start_balance_status" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="start_balance_status" id="start_balance_status">
                                        <option value="">
                                            اختر الحالة
                                        </option>
                                        <option @if (old('start_balance_status') == '2') selected  @else  '' @endif value="2">
                                            مدين
                                        </option>
                                        <option @if (old('start_balance_status') == '1') selected  @else  '' @endif value="1">
                                            دائن
                                        </option>
                                        <option @if (old('start_balance_status') == '3' and (old('start_balance_status') == '3') != '') selected  @else '' @endif value="3">
                                            متزن
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>رصيد اول مدة</label>
                                    @if (old('start_balance') == '' and old('start_balance_status') != '3' or $errors->has('start_balance'))
                                        <b class="start_start_balance" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <div class="start_balanceDiv1"
                                        @if (old('start_balance_status') != 3) '' @else style="display: none;" @endif>
                                        <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                            name="start_balance" id="start_balance" value="{{ old('start_balance') }}"
                                            class="form-control" placeholder="ادخل المبلغ بدون سالب">
                                    </div>
                                    <div class="start_balanceDiv2"
                                        @if (old('start_balance_status') == 3) '' @else style="display: none;" @endif>
                                        <input name="start_balance" class="form-control" value="0.00" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>العنوان</label>
                                    @if (old('address') == '' or $errors->has('address'))
                                        <b class="start_address" style="color: rgb(240, 43, 17);"></b>
                                    @endif
                                    <input type="address" name="address" id="address" value="{{ old('address') }}"
                                        class="form-control" placeholder="ادخل عنوان العميل">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>رقم الهاتف</label>
                                    @if (old('phone') == '' or $errors->has('phone'))
                                        <b class="start_phone" style="color: rgb(240, 43, 17);"></b>
                                    @endif
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                        class="form-control" placeholder="ادخل رقم هاتف العميل">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>حالة التفعيل</label>
                                    @if (old('active') == '' or $errors->has('active'))
                                        <b class="start_active" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="active" id="active">
                                        <option value="">
                                            اختر الحالة
                                        </option>
                                        <option @if (old('active') == '1') selected  @else  '' @endif
                                            value="1">
                                            مفعل
                                        </option>
                                        <option @if (old('active') == '0' and (old('active') == '0') != '') selected  @else '' @endif value="0">
                                            معطل
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ملاحظات</label>
                                    @if (old('notes') == '' or $errors->has('notes'))
                                        <b class="start_notes" style="color: rgb(240, 43, 17);"></b>
                                    @endif
                                    <input type="text" name="notes" id="notes" value="{{ old('notes') }}"
                                        class="form-control" placeholder="ادخل الملاحظات">
                                </div>
                            </div>
                            <div class="col-sm-12" style="border: solid 1px #9290e7;margin: 10px;background: #f0f0f3;">
                                <div class="form-group">
                                    <img src="{{ asset('assets/admin/uploads/suppliers_imgs/default.png') }}"
                                        style="width: 100px" class="img-thumbnail image-preview" alt="">
                                </div>
                                <div class="form-group">
                                    <label>صورة المورد</label>
                                    <input type="file" name="photo" class="form-control image">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card_title_center">
                    <button id="do_add_suppliers" type="submit" class="btn btn-success">اضافة</button>
                    <a href="{{ route('suppliers.index') }}" type="button" class="btn btn-danger">الغاء</a>
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
    <script src="{{ URL::asset('assets/admin/js/suppliers_validation.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/suppliers.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/image_preview.js') }}"></script>
@endsection
