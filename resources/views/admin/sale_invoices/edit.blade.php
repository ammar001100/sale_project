<!-- 
ملاحظات
اسم المتغير مع علامة "_" لمراة الصنف لعرض الاسعار
و بدونها لانشاء فاتورة مبيعات
-->
@extends('admin.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('headTitle')
فواتير المبيعات
@endsection
@section('pageTitle')
فواتير المبيعات
@endsection
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item">المبيعات</li>
    <li class="breadcrumb-item active">فواتير المبيعات</li>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <!-- <h6 class=" card_title_center">بيانات فواتير المبيعات</h6><br> -->
                <div class="row">
                    @if (isset($data) && $data->count() >= 5)
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="icheck-success d-inline">
                                <input type="radio" value="auto_serial" name="r3" id="radio" checked>
                                <label for="radio">
                                </label>
                            </div>
                            <label>بحث بالكود الألي</label>
                            <div class="icheck-success d-inline">
                                <input type="radio" value="doc_no" name="r3" id="radio2">
                                <label for="radio2">
                                </label>
                            </div>
                            <label>بحث بكود اصل الشراء</label>
                        </div>
                        <input type="text" id="search_by_text" class="form-control" placeholder="ادخل الكود الألي او كود أصل الشراء">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>بحث بالمورد</label>
                            <select class="custom-select select2" name="supplier_id_search" id="supplier_id_search">
                                <option value="all">
                                    الكل
                                </option>
                                @if (@isset($supplier) && !@empty($supplier))
                                @foreach ($supplier as $info)
                                <option value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>بحث بالمخازن</label>
                            <select class="custom-select select2" name="store_id_search" id="store_id_search">
                                <option value="all">الكل</option>
                                @if (@isset($stores) && !@empty($stores))
                                @foreach ($stores as $info)
                                <option value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>بحث بالتاريخ من</label>
                            <input type="date" id="order_date_form" name="order_date_form" class="form-control" placeholder="بحث من تاريخ">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>بحث بالتاريخ الى</label>
                            <input type="date" id="order_date_to" name="order_date_to" class="form-control" placeholder="بحث الى تارخ">
                        </div>
                    </div>
                    <input type="hidden" id="ajax_search_url" value="{{ route('supplier_orders.ajax_search') }}">
                    <input type="hidden" id="token" value="{{ csrf_token() }}">
                    @endif
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-2 card_body_style">
                <div id="ajax_responce_searchDiv" class="">
                    <div class="" id="">
                        <div class="">
                            <div class="modal-content bg-info">

                                <div class="modal-body" id="ModelSaleInvoice_body" style="background-color: white;color:black;">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header card_header_style">
                                                <h3 class="card-title card_title_center">اضافة فاتورة مبيعات</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body card_body_style">
                                                @if (isset($data) && !empty($data))
                                                <form role="form" action="{{ route('sale_invoices.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" id="store_url" value="{{ route('sale_invoices.store') }}">
                                                    <input type="hidden" id="ajax_get_uom_url" value="{{ route('sale_invoices.ajax_get_uom') }}">
                                                    <input type="hidden" id="get_item_card_batches_url" value="{{ route('sale_invoices.get_item_card_batches') }}">
                                                    <input type="hidden" id="get_unit_cost_price_url" value="{{ route('sale_invoices.get_unit_cost_price') }}">
                                                    <input type="hidden" id="get_new_item_row_url" value="{{ route('sale_invoices.get_new_item_row') }}">
                                                    <input type="hidden" id="approve_invoice_now_url" value="{{ route('supplier_orders.approve_invoice_now') }}">
                                                    <input type="hidden" id="token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="id" value="">
                                                    <table id="example1" class="table">
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>تاريخ الفاتورة</label>
                                                                    @if (old('invoice_date') == '' or $errors->has('invoice_date'))
                                                                    <b class="start_invoice_date" style="color: rgb(240, 43, 17);">
                                                                        <smal style="color: green;"><span class="fa fa-check">
                                                                    </b>
                                                                    @endif
                                                                    <input type="date" name="invoice_date" id="invoice_date" value="@php echo date(" Y-m-d"); @endphp" class="form-control">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>هل يوجد عميل</label>
                                                                    @if (old('is_has_customer') == '' or $errors->has('is_has_customer'))
                                                                    <b class="start_is_has_customer" style="color: rgb(240, 43, 17);">
                                                                        <smal style="color: green;"><span class="fa fa-check"></span></small>
                                                                    </b>
                                                                    @endif
                                                                    <select name="is_has_customer" id="is_has_customer" class="form-control">
                                                                        <option value="1" selected>يوجد عميل</option>
                                                                        <option value="2">بدون عميل</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>العميل
                                                                        -<a title="اضافة عميل جديد" href="#" id="show_new_customer_model">جديد <i class="fa fa-plus-circle"></i></a>
                                                                    </label>
                                                                    @if (old('customer_id') == '' or $errors->has('customer_id'))
                                                                    <b class="start_customer_id" style="color: rgb(240, 43, 17);">*</b>
                                                                    @endif
                                                                    <select class="custom-select select2" name="customer_id" id="customer_id">
                                                                        <option value="">اختر العميل</option>
                                                                        @if (@isset($customers) && !@empty($customers))
                                                                        @foreach ($customers as $info)
                                                                        <option value="{{ $info->id }}">{{ $info->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>المندوب</label>
                                                                    @if (old('delegate_id') == '' or $errors->has('delegate_id'))
                                                                    <b class="start_delegate_id" style="color: rgb(240, 43, 17);">*</b>
                                                                    @endif
                                                                    <select class="custom-select select2" name="delegate_id" id="delegate_id">
                                                                        <option value="">اختر المندوب</option>
                                                                        @if (@isset($delegates) && !@empty($delegates))
                                                                        @foreach ($delegates as $info)
                                                                        <option value="{{ $info->id }}">{{ $info->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>فئة الفاتورة</label>
                                                                    @if (old('sales_matrial_type_id') == '' or $errors->has('sales_matrial_type_id'))
                                                                    <b class="start_sales_matrial_type_id" style="color: rgb(240, 43, 17);">*</b>
                                                                    @endif
                                                                    <select class="custom-select select2" name="sales_matrial_type_id" id="sales_matrial_type_id">
                                                                        <option value="">اختر الفئة</option>
                                                                        @if (@isset($sales_matrial_types) && !@empty($sales_matrial_types))
                                                                        @foreach ($sales_matrial_types as $info)
                                                                        <option value="{{ $info->id }}">{{ $info->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>الصنف</label>
                                                                    @if (old('item_card_id') == '' or $errors->has('item_card_id'))
                                                                    <b class="start_item_card_id" style="color: rgb(240, 43, 17);">*</b>
                                                                    @endif
                                                                    <select name="item_card_id" id="item_card_id" class="custom-select select2">
                                                                        <option value=""> اختر الصنف</option>
                                                                        @if (@isset($item_cards) && !@empty($item_cards))
                                                                        @foreach ($item_cards as $info)
                                                                        <option data-item_type="{{ $info->item_type }}" value="{{ $info->id }}">
                                                                            {{ $info->name }}
                                                                        </option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td style="display: none;" id="TdStoreId">
                                                                <div class="form-group">
                                                                    <label>المخزن</label>
                                                                    @if (old('store_id') == '' or $errors->has('store_id'))
                                                                    <b class="start_store_id" style="color: rgb(240, 43, 17);">*</b>
                                                                    @endif
                                                                    -<a title="اضافة مخزن جديد" href="#" id="show_new_customer_model">جديد <i class="fa fa-plus-circle"></i></a>
                                                                    <select class="custom-select select2" name="store_id" id="store_id">
                                                                        <option value="">اختر المخزن</option>
                                                                        @if (@isset($stores) && !@empty($stores))
                                                                        @foreach ($stores as $info)
                                                                        <option @if (old('store_id')==$info->id) selected @else '' @endif
                                                                            value="{{ $info->id }}">{{ $info->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td id="TdDivUom" style="display: none;">
                                                                <div class="form-group">
                                                                    <div class="DivUom">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td id="TdDivBatche" style="display: none;" colspan="2">
                                                                <div class="form-group">
                                                                    <div class="DivBatche">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>حالة البيع</label>
                                                                    @if (old('is_bounce_or_other') == '' or $errors->has('is_bounce_or_other'))
                                                                    <b class="start_is_bounce_or_other">
                                                                        <smal style="color: green;"><span class="fa fa-check"></span></small>
                                                                    </b>
                                                                    @endif
                                                                    <select name="is_bounce_or_other" id="is_bounce_or_other" class="form-control">
                                                                        <option value="1" selected>عادي</option>
                                                                        <option value="2">بونص</option>
                                                                        <option value="3">دعاية</option>
                                                                        <option value="4">هالك</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>السعر</label>
                                                                    @if (old('unit_cost_price') == '' or $errors->has('unit_cost_price'))
                                                                    <b class="start_unit_cost_price" style="color: rgb(240, 43, 17);">*</b>
                                                                    @endif
                                                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" type="text" name="unit_cost_price" id="unit_cost_price" value="@if(old('unit_cost_price')) {{ old('unit_cost_price') }} @endif" class="form-control" placeholder="ادخل السعر">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>نوع البيع</label>
                                                                    @if (old('sales_type') == '' or $errors->has('sales_type'))
                                                                    <b class="start_sales_type">
                                                                        <smal style="color: green;"><span class="fa fa-check"></span></small>
                                                                    </b>
                                                                    @endif
                                                                    <select name="sales_type" id="sales_type" class="form-control">
                                                                        <option value="1" selected>قطاعي</option>
                                                                        <option value="2">جملة</option>
                                                                        <option value="3">نص جملة</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>الكمية</label>
                                                                    @if (old('quentity') == '' or $errors->has('quentity'))
                                                                    <b class="start_quentity" style="color: rgb(240, 43, 17);">
                                                                        <smal style="color: green;"><span class="fa fa-check"></span></small>
                                                                    </b>
                                                                    @endif
                                                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" type="text" name="quentity" id="quentity" value="@if(old('quentity')) {{ old('quentity') }} @else 1 @endif" class="form-control" placeholder="ادخل الكمية">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>الاجمالي</label>
                                                                    <input type="text" name="total_price" id="total_price" value="" class="form-control" readonly>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">
                                                                <button style="margin-top:35px;" id="AddItemToInvoiceDetailsAdd" class="btn btn-sm btn-danger">اضف للفاتورة</button></button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div class="card-header card_header_style">
                                                        <h3 class="card-title card_title_center">الاصناف المضافة للفاتورة</h3>
                                                    </div>
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="custom_thead">
                                                            <tr class="custom_thead">
                                                                <th>المخزن</th>
                                                                <th>نوع البيع</th>
                                                                <th>الصنف</th>
                                                                <th>وحدة البيع</th>
                                                                <th>الكمية</th>
                                                                <th>سعر الوحدة</th>
                                                                <th>الاجمالي</th>
                                                                <th>الاجراءت</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="itemRow">
                                                            @if (isset($data->sale_inv_details) && count($data->sale_inv_details) > 0)
                                                            @foreach ($data->sale_inv_details as $index=> $info)
                                                            <tr>
                                                                <td>{{ $info['store_name'] }}
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][item_card_id]" value="{{ $info['item_card_id'] }}" class="item_card_id_array">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][store_id]" value="{{ $info['store_id'] }}" class="store_id_array">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][sales_type]" value="{{ $info['sales_type'] }}" class="sales_type">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][uom_id]" value="{{ $info['uom_id'] }}" class="uom_id_array">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][itemcard_batche]" value="{{ $info['itemcard_batche'] }}" class="itemcard_batche_array">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][quentity]" value="{{ $info['quentity'] }}" class="quentity_array">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][unit_cost_price]" value="{{ $info['unit_cost_price'] }}" class="unit_cost_price_array">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][is_bounce_or_other]" value="{{ $info['is_bounce_or_other'] }}" class="is_bounce_or_other_array">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][total_price]" value="{{ $info['total_price'] }}" class="total_price_array">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][is_parent_uom]" value="{{ $info['is_parent_uom'] }}" class="is_parent_uom_array">
                                                                    <input type="hidden" name="items_array[{{ $info['index'] }}][total_price]" value="{{ $info['total_price'] }}" class="is_parent_uom_array">
                                                                    <input type="hidden" name="total_cost_items_array[]" value="{{ $info['total_price'] }}" class="total_cost_items_array">
                                                                </td>
                                                                <td>{{ $info['sale_item_type'] }}</td>
                                                                <td>{{ $info['item_card_name'] }}</td>
                                                                <td>{{ $info['uom_name'] }}</td>
                                                                <td>{{ $info['quentity'] * 1}}</td>
                                                                <td>{{ $info['unit_cost_price'] * 1}}</td>
                                                                <td>{{ $info['total_price'] }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-sm remove_item_row">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @else
                                                            <div class="card_title_center">
                                                                <p class="btn btn-danger btn-sm">
                                                                    عفوا لاتوجد بيانات
                                                                </p>
                                                            </div>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <hr style="border:1px solid #3c8dbc;">
                                                    <table id="example1" class="table">
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>اجمالي الاصناف بالفاتورة</label>
                                                                    <input type="text" name="total_cost_items" id="total_cost_items" value="" class="form-control" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>نسبة ضريبة القيمة المضافة</label>
                                                                    <input type="text" name="tax_percent" id="tax_percent" value="" class="form-control" placeholder="">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>قيمة الضريبة المضافة</label>
                                                                    <input type="text" name="tax_value" id="tax_value" value="" class="form-control" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>قيمة الاجمالي قبل الخصم</label>
                                                                    <input type="text" name="total_befor_discount" id="total_befor_discount" value="" class="form-control" readonly>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>نوع الخصم</label>
                                                                    <select name="discount_type" id="discount_type" class="form-control">
                                                                        <option value="">لا يوجد</option>
                                                                        <option value="1">نسبة مأوية</option>
                                                                        <option value="2">قيمة يدوي</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>نسبة الخصم</label>
                                                                    <input type="text" name="discount_percent" id="discount_percent" value="" class="form-control" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>قيمة الخصم</label>
                                                                    <input type="text" name="discount_value" id="discount_value" value="" class="form-control" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>قيمة الاجمالي بعد الخصم</label>
                                                                    <input type="text" name="total_cost" id="total_cost" value="" class="form-control" readonly>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>خزنة التحصيل</label>
                                                                    <input type="text" name="treasury_name" id="treasury_name" value="{{$admin_shift->treasury->name}}" class="form-control" readonly>
                                                                    <input type="hidden" name="treasury_id" id="treasury_id" value="{{$admin_shift->treasury->id}}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label> الرصيد المتاح بالخزنة</label>
                                                                    <input type="text" name="treasury_money" id="treasury_money" value="{{$money*1}}" class="form-control" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>نوع الفاتورة</label>
                                                                    <select name="pill_type" id="pill_type" class="form-control">
                                                                        <option value="1">كاش</option>
                                                                        <option value="2">أجل</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label> المحصل الان</label>
                                                                    <input type="text" name="what_paid" id="what_paid" value="0" class="form-control" placeholder="">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label>المتبقي تحصيلة </label>
                                                                    <input type="text" name="what_remain" id="what_remain" value="0" class="form-control" readonly>
                                                                </div>
                                                            </td>
                                                            <td colspan="3">
                                                                <div class="form-group">
                                                                    <label> الملاحظات على الفاترة </label>
                                                                    <input type="text" name="notes" id="notes" value="" class="form-control" placeholder="ادخل ملاحظاتك">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <button type="submit" style="display: none;" id="save_sale_invoice_add" class="btn btn-sm btn-success">حفظ الفاتورة</button>
                                                            </td>
                                                        </tr>
                                                    </table>
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

                                </div>
                                <div class="modal-footer justify-content-between">
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/admin/js/sale_invoices.js') }}"></script>
<script src="{{ URL::asset('assets/admin/js/sale_invoices_.js') }}"></script>
<script src="{{ URL::asset('assets/admin/js/sale_invoices_seaech.js') }}"></script>
<!-- InputMask -->
<script src="{{ URL::asset('assets/admin/plugins/inputmask/jquery.inputmask.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/moment/moment.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ URL::asset('assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}">
</script>
<!-- Select2 -->
<script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

</script>
@endsection
