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
<button data-toggle="modal" data-target="#ModelSaleInvoice" id="model_sale_invoice" class="btn btn-sm btn-primary">
    مراة الفاتورة لعرض الاسعار</button>
<button data-toggle="modal" data-target="#ModelSaleInvoiceAdd" id="model_sale_invoice_add" class="btn btn-sm btn-success">
    اضافة فاتورة</button>
@endsection
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('sale_invoices.index') }}">المبيعات</a></li>
    <li class="breadcrumb-item active">فواتير المبيعات</li>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>البحث</h5>
                <hr>
                <div class="row">
                    @if (isset($data) && $data->count() >= 5)
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="icheck-success d-inline">
                                <input type="radio" value="auto_serial" name="r3" id="radio" checked>
                                <label for="radio">
                                </label>
                            </div>
                            <label>بحث بكود الفاتورة </label>
                            <div class="icheck-success d-inline">
                                <input type="radio" value="customer_id" name="r3" id="radio2">
                                <label for="radio2">
                                </label>
                            </div>
                            <label>بحث بكود العميل </label>
                            <div class="icheck-success d-inline">
                                <input type="radio" value="account_number" name="r3" id="radio3">
                                <label for="radio3">
                                </label>
                            </div>
                            <label>بحث برقم الحساب</label>
                        </div>
                        <input type="text" id="search_by_text" class="form-control" placeholder="ادخل الكود الألي او كود أصل الشراء">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>بحث بالعميل</label>
                            <select class="custom-select select2" name="customer_id_search" id="customer_id_search">
                                <option value="all">الكل</option>
                                <option value="without">بدون عميل</option>
                                @if (@isset($customers) && !@empty($customers))
                                @foreach ($customers as $info)
                                <option value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>بحث بالمندوب</label>
                            <select class="custom-select select2" name="delegate_id_search" id="delegate_id_search">
                                <option value="all">الكل</option>
                                @if (@isset($delegates) && !@empty($delegates))
                                @foreach ($delegates as $info)
                                <option value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>بحث بالتاريخ من</label>
                            <input type="date" id="invoice_date_form" name="invoice_date_form" class="form-control" placeholder="بحث من تاريخ">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>بحث بالتاريخ الى</label>
                            <input type="date" id="invoice_date_to" name="invoice_date_to" class="form-control" placeholder="بحث الى تارخ">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>بحث بنوع الفاتورة</label>
                            <select class="custom-select select2" name="pill_type_search" id="pill_type_search">
                                <option value="all">
                                    الكل
                                </option>
                                <option value="1">كاش</option>
                                <option value="2">أجل</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>بحث بفئة الفاتورة</label>
                            <select class="custom-select select2" name="sales_matrial_type_id_search" id="sales_matrial_type_id_search">
                                <option value="all">
                                    الكل
                                </option>
                                @if (@isset($sales_matrial_types) && !@empty($sales_matrial_types))
                                @foreach ($sales_matrial_types as $info)
                                <option value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="ajax_search_url" value="{{ route('sale_invoices.ajax_search') }}">
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    @endif
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-2 card_body_style">
                <h5> بيانات الفواتير </h5>
                <hr>
                <div id="ajax_responce_searchDiv" class="">
                    @if (isset($data) && $data->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <tr class="custom_thead">
                                <th>كود الفاتورة</th>
                                <th>العميل</th>
                                <th>نوع الفاتورة</th>
                                <th>فئة الفاتورة</th>
                                <th>اجمالي الفاتورة</th>
                                <th>تاريخ الفاتورة</th>
                                <th>الاجراءت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                            <tr>
                                <td>{{ $info->auto_serial }}</td>
                                <td>
                                    @if (isset($info->customer->name))
                                    {{ $info->customer->name }}
                                    @else
                                    <b style="color: rgb(213, 88, 88)">بدون عميل</b>
                                    @endif
                                </td>
                                <td>
                                    @if ($info->pill_type == 1)
                                    كاش
                                    @elseif($info->pill_type == 2)
                                    أجل
                                    @else
                                    غير محدد
                                    @endif
                                </td>
                                <td>
                                    @if ($info->sales_matrial_type)
                                    {{ $info->sales_matrial_type->name }}
                                    @else
                                    <b style="color: red">لا توجد فئة ربما تم حذفها</b>
                                    @endif
                                </td>
                                <td>
                                    {{ $info->sale_inv_details->sum('total_price' ) }}
                                </td>
                                <td>
                                    {{ $info->invoice_date }}
                                </td>
                                <td>
                                    <a href="{{ route('sale_invoices.show', $info->id) }}" class="btn btn-primary btn-sm">
                                        التفاصيل
                                    </a>
                                    @if ($info->is_approved == 0)
                                    <!-- <a href="{{ route('sale_invoices.edit', $info->id) }}" class="btn btn-sm btn-info"> 
                                            <i class="fas fa-pencil-alt"></i>
                                         </a>  -->
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete{{ $info->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                    <!-- are you shue modal -->
                                    <div class="modal fade" id="modal-delete{{ $info->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">تحذير</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>هل انت متاكد من عملية الحذف ؟</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <form action="{{ route('sale_invoices.destroy', $info->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-light">متابعة</button>
                                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">الغاء</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- end are you shue modal -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <div class="col-md-12">
                        {{ $data->links() }}
                    </div>
                    <br>
                    @else
                    <div class="card_title_center">
                        <p class="btn btn-danger btn-sm">
                            عفوا لاتوجد بيانات
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            <!-- /.card-body -->
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
</div>
<!-- add sale_invoice modal -->
<div class="modal fade" id="ModelSaleInvoice">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h4 class="modal-title">مراة الفاتورة لعرض الاسعار</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ModelSaleInvoice_body" style="background-color: white;color:black;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card_header_style">
                            <h3 class="card-title card_title_center">مراة الفاتورة لعرض الاسعار</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body card_body_style">
                            @if (isset($data) && !empty($data))
                            <form role="form" action="{{ route('supplier_orders.approved') }}" method="POST">
                                @csrf
                                <input type="hidden" id="ajax_get_uom_url_" value="{{ route('sale_invoices.ajax_get_uom_') }}">
                                <input type="hidden" id="get_item_card_batches_url_" value="{{ route('sale_invoices.get_item_card_batches_') }}">
                                <input type="hidden" id="get_unit_cost_price_url_" value="{{ route('sale_invoices.get_unit_cost_price_') }}">
                                <input type="hidden" id="get_new_item_row_url_" value="{{ route('sale_invoices.get_new_item_row_') }}">
                                <input type="hidden" id="token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="">
                                <table id="example1" class="table">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label>الصنف</label>
                                                @if (old('item_card_id_') == '' or $errors->has('item_card_id_'))
                                                <b class="start_item_card_id_" style="color: rgb(240, 43, 17);">*</b>
                                                @endif
                                                <select name="item_card_id_" id="item_card_id_" class="custom-select select2">
                                                    <option value=""> اختر الصنف</option>
                                                    @if (@isset($item_cards) && !@empty($item_cards))
                                                    @foreach ($item_cards as $info)
                                                    <option @if (old('item_card_id_')==$info->id) selected @else '' @endif
                                                        data-item_type="{{ $info->item_type }}" value="{{ $info->id }}">
                                                        {{ $info->name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </td>
                                        <td style="display: none;" id="TdStoreId_">
                                            <div class="form-group">
                                                <label>المخزن</label>
                                                @if (old('store_id_') == '' or $errors->has('store_id_'))
                                                <b class="start_store_id_" style="color: rgb(240, 43, 17);">*</b>
                                                @endif
                                                <select class="custom-select select2" name="store_id_" id="store_id_">
                                                    <option value="">اختر المخزن</option>
                                                    @if (@isset($stores) && !@empty($stores))
                                                    @foreach ($stores as $info)
                                                    <option @if (old('store_id_')==$info->id) selected @else '' @endif
                                                        value="{{ $info->id }}">{{ $info->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </td>
                                        <td id="TdDivUom_" style="display: none;">
                                            <div class="form-group">
                                                <div class="DivUom_">
                                                </div>
                                            </div>
                                        </td>
                                        <td id="TdDivBatche_" style="display: none;">
                                            <div class="form-group">
                                                <div class="DivBatche_">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label>حالة البيع</label>
                                                @if (old('is_bounce_or_other_') == '' or $errors->has('is_bounce_or_other_'))
                                                <b class="start_is_bounce_or_other_">
                                                    <smal style="color: green;"><span class="fa fa-check"></span></small>
                                                </b>
                                                @endif
                                                <select name="is_bounce_or_other_" id="is_bounce_or_other_" class="form-control">
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
                                                @if (old('unit_cost_price_') == '' or $errors->has('unit_cost_price_'))
                                                <b class="start_unit_cost_price_" style="color: rgb(240, 43, 17);">*</b>
                                                @endif
                                                <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" type="text" name="unit_cost_price_" id="unit_cost_price_" value="@if(old('unit_cost_price_')) {{ old('unit_cost_price_') }} @endif" class="form-control" placeholder="ادخل السعر">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>نوع البيع</label>
                                                @if (old('sales_type_') == '' or $errors->has('sales_type_'))
                                                <b class="start_sales_sales_type_">
                                                    <smal style="color: green;"><span class="fa fa-check"></span></small>
                                                </b>
                                                @endif
                                                <select name="sales_type_" id="sales_type_" class="form-control">
                                                    <option value="1" selected>قطاعي</option>
                                                    <option value="2">جملة</option>
                                                    <option value="3">نص جملة</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>الكمية</label>
                                                @if (old('quentity_') == '' or $errors->has('quentity_'))
                                                <b class="start_quentity_" style="color: rgb(240, 43, 17);">
                                                    <smal style="color: green;"><span class="fa fa-check"></span></small>
                                                </b>
                                                @endif
                                                <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" type="text" name="quentity_" id="quentity_" value="@if(old('quentity_')) {{ old('quentity_') }} @else 1 @endif" class="form-control" placeholder="ادخل الكمية">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label>الاجمالي</label>
                                                <input type="text" name="total_price_" id="total_price_" value="" class="form-control" readonly>
                                            </div>
                                        </td>
                                        <td colspan="4">
                                            <button style="margin-top:35px;" id="AddItemToInvoiceDetails" class="btn btn-sm btn-info">اضف للفاتورة</button></button>
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
                                    <tbody id="itemRow_">
                                    </tbody>
                                </table>
                                <hr style="border:1px solid #3c8dbc;">
                                <table id="example1" class="table">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label>اجمالي الاصناف بالفاتورة</label>
                                                <input type="text" name="total_cost_items_" id="total_cost_items_" value="" class="form-control" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>نسبة ضريبة القيمة المضافة</label>
                                                <input type="text" name="tax_percent_" id="tax_percent_" value="" class="form-control" placeholder="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>قيمة الضريبة المضافة</label>
                                                <input type="text" name="tax_value_" id="tax_value_" value="" class="form-control" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>قيمة الاجمالي قبل الخصم</label>
                                                <input type="text" name="total_befor_discount_" id="total_befor_discount_" value="" class="form-control" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label>نوع الخصم</label>
                                                <select name="discount_type_" id="discount_type_" class="form-control">
                                                    <option value="">لا يوجد</option>
                                                    <option value="1">نسبة مأوية</option>
                                                    <option value="2">قيمة يدوي</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>نسبة الخصم</label>
                                                <input type="text" name="discount_percent_" id="discount_percent_" value="" class="form-control" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>قيمة الخصم</label>
                                                <input type="text" name="discount_value_" id="discount_value_" value="" class="form-control" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>قيمة الاجمالي بعد الخصم</label>
                                                <input type="text" name="total_cost_" id="total_cost_" value="" class="form-control" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label>خزنة التحصيل</label>
                                                <input type="text" name="treasury_name_" id="treasury_name_" value="
                                                @if(isset($admin_shift->treasury->name))
                                                {{$admin_shift->treasury->name}}
                                                @else
                                                لا توجد
                                                @endif
                                                " class="form-control" readonly>
                                                <input type="hidden" name="treasury_id_" id="treasury_id_" value="
                                                @if(isset($admin_shift->treasury->id))
                                                {{$admin_shift->treasury->id}} 
                                                @endif
                                                ">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label> الرصيد المتاح بالخزنة</label>
                                                <input type="text" name="treasury_money_" id="treasury_money_" value="{{$money*1}}" class="form-control" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label>نوع الفاتورة</label>
                                                <select name="pill_type_" id="pill_type_" class="form-control">
                                                    <option value="1">كاش</option>
                                                    <option value="2">أجل</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label> المحصل الان</label>
                                                <input type="text" name="what_paid_" id="what_paid_" value="0" class="form-control" placeholder="">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label>المتبقي تحصيلة </label>
                                                <input type="text" name="what_remain_" id="what_remain_" value="0" class="form-control" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <button style="display: none;" id="save_sale_invoice" class="btn btn-sm btn-success">طباعة الفاتورة</button>
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
<!-- end sale_invoice modal -->
<!-- -------------------------------------------------
        --------------------------------------------------
        --------------------------------------------------
        --------------------------------------------------
    -->
<!-- add sale_invoice_add modal -->
<div class="modal fade" id="ModelSaleInvoiceAdd">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <h4 class="modal-title">اضافة فاتورة مبيعات</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
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
                                                <input type="date" name="invoice_date" id="invoice_date" value="<?php echo date("Y-m-d"); ?>" class="form-control">
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
                                            <div class="form-group" id="DivCustomerId" style="display: show;">
                                                <label>العميل</label>
                                                @if (old('customer_id') == '' or $errors->has('customer_id'))
                                                <b class="start_customer_id" style="color: rgb(240, 43, 17);">*</b>
                                                @endif
                                                <a title="اضافة عميل جديد" href="#" id="show_new_customer_model"><i class="fa fa-plus-circle"></i></a>
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
                                                <a title="اضافة عميل جديد" href="#" id="show_new_customer_model"><i class="fa fa-plus-circle"></i></a>
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
                                                <!-- <label>الصنف</label> -->
                                                @if (old('item_card_id') == '' or $errors->has('item_card_id'))
                                                <b class="start_item_card_id" style="color: rgb(240, 43, 17);">*</b>
                                                @endif
                                                <input type="text" class="form-control form-control-sm" style="margin-bottom: 0;background-color: greenyellow" placeholder=" باركود - كود - اسم">
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
                                                <a title="اضافة مخزن جديد" href="#" id="show_new_customer_model"><i class="fa fa-plus-circle"></i></a>
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
                                            <button style="margin-top:35px;" id="AddItemToInvoiceDetailsAdd" class="btn btn-sm btn-info">اضف للفاتورة</button></button>
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
                                                <input type="text" name="treasury_name" id="treasury_name" value="
                                                @if(isset($admin_shift->treasury->name))
                                                {{$admin_shift->treasury->name}}
                                                @else
                                                لا توجد
                                                @endif
                                                " class="form-control" readonly>
                                                <input type="hidden" name="treasury_id" id="treasury_id" value="
                                                @if(isset($admin_shift->treasury->id))
                                                {{$admin_shift->treasury->id}} 
                                                @endif
                                                ">
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
                                                <input type="text" name="notes" id="notes" value="" style="margin-bottom: 0;background-color: rgb(213, 212, 212)" class="form-control" placeholder="ادخل ملاحظاتك">
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
<!-- end sale_invoice_add modal -->
@endsection
@section('script')
<script src="{{ URL::asset('assets/admin/js/sale_invoices.js') }}"></script>
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
