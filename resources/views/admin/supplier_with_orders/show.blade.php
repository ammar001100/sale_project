@extends('admin.layouts.app')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ URL::asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('headTitle')
    تفاصيل فاتورة المشتريات
@endsection
@section('pageTitle')
    تفاصيل فاتورة المشتريات رقم ({{ $data->auto_serial }})
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">حركات مخزنية</li>
        <li class="breadcrumb-item"><a href="{{ route('supplier_orders.index') }}">فواتير المشتريات</a></li>
        <li class="breadcrumb-item"><a href="{{ route('supplier_orders.index') }}">الفاتورة رقم ({{ $data->auto_serial }})</a>
        </li>
        <li class="breadcrumb-item active">عرض تفاصيل</li>
    </ol>
@endsection
@section('content')
    <div class="row" id="loade_page">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">تفاصيل فاتورة المشتريات</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body card_body_style">
                    @if (isset($data) && $data->count() > 0)
                        <table id="example1" class="table table-bordered table-striped">
                            <tr>
                                <td class="width20">
                                    <b style="color: #000">كود الفاتورة الألي</b>
                                </td>
                                <td>
                                    {{ $data->auto_serial }}
                                </td>
                                <td class="width20">
                                    <b style="color: #000">كود الفاتورة بأصل فاتورة المورد</b>
                                </td>
                                <td>
                                    {{ $data->doc_no }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width20">
                                    <b style="color: #000">تاريخ الفاتورة</b>
                                </td>
                                <td>{{ $data->order_date }}</td>
                                <td class="width20">
                                    <b style="color: #000">اسم المورد</b>
                                </td>
                                <td>
                                    @if (isset($data->supplier->name))
                                        {{ $data->supplier->name }}
                                    @else
                                        غير موجود ربما تم حذفه
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width20">
                                    <b style="color: #000">المخزن</b>
                                </td>
                                <td>
                                    @if (isset($data->store->name))
                                        {{ $data->store->name }}
                                    @else
                                        غير موجود ربما تم حذفه
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    <b style="color: #000">نوع الفاتورة</b>
                                </td>
                                <td>
                                    @if ($data->pill_type == 1)
                                        كاش
                                    @else
                                        أجل
                                    @endif
                                </td>
                                <td class="width30">
                                    <b style="color: #000">اجمالي قيمة الفاتورة</b>
                                </td>
                                <td>
                                    {{ $data->total_befor_discount }}
                                </td>
                            </tr>
                            @if ($data->discount_type)
                                <tr>
                                    <td class="width30">
                                        الخصم على الفاتورة
                                    </td>
                                    <td>
                                        @if ($data->discount_type == 1)
                                            خصم بنسبة ({{ $data->discount_percent * 1 }}) و قيمتها
                                            ({{ $data->discount_value * 1 }})
                                        @else
                                            خصم يدوي و قيمته ({{ $data->discount_value * 1 }})
                                        @endif
                                    </td>
                                @else
                                    <td class="width30">
                                        الخصم على الفاتورة
                                    </td>
                                    <td>
                                        لا يوجد
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="width30">
                                    نسبة القيمة المضافة
                                </td>
                                <td>
                                    @if ($data->tax_percent <= 0)
                                        لا يوجد
                                    @else
                                        بنسبة ({{ $data->tax_percent * 1 }}) % و قيمتها ({{ $data->tax_value * 1 }})
                                    @endif
                                </td>
                                <td class="width30">
                                    تاريخ الأضافة
                                </td>
                                <td>
                                    @php
                                        $dt = new DateTime($data['created_at']);
                                        $date = $dt->format('Y-m-d');
                                        $time = $dt->format('H:i');
                                        $newDateTime = date('A', strtotime($time));
                                        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساء';
                                    @endphp
                                    {{ $date }}
                                    -
                                    {{ $time }}
                                    {{ $newDateTimeType }}
                                    - بواسطة :
                                    {{ $data->added_by_admin }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    تاريخ اخر تحديث
                                </td>
                                <td>
                                    @if ($data['updated_by'] > 0 and $data['updated_by'] != null)
                                        @php
                                            $dt = new DateTime($data['updated_at']);
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('H:i');
                                            $newDateTime = date('A', strtotime($time));
                                            $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساء';
                                        @endphp
                                        {{ $date }}
                                        -
                                        {{ $time }}
                                        {{ $newDateTimeType }}
                                        - بواسطة :
                                        {{ $data->updated_by_admin }}
                                    @else
                                        لا يوجد تحديث
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if ($data->is_approved == 0)
                                        <button data-toggle="modal" data-target="#ModelApproveInvoice" id="do_close_approve_invoice" class="btn btn-sm btn-success">تحميل الاعتماد و الترحيل</button>
                                        <a href="{{ route('supplier_orders.edit', $data->id) }}"
                                            class="btn btn-sm btn-info"> <i class="fas fa-pencil-alt"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modal-delete{{ $data->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div class="card-header card_header_style">
                            @if ($data->is_approved == 0)
                                <h3 class="card-title card_title_center">اصناف الفاتورة
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#Add_item_cards">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </h3>
                            @endif
                        </div>
                        <div class="card-body table-responsive p-2 card_body_style">
                            <div id="loade_item">
                                @if (isset($supplier_with_order_details) && $supplier_with_order_details->count() > 0)
                                    @php
                                        $i = 1;
                                    @endphp
                                    <table class="table table-bordered table-hover">
                                        <thead class="custom_thead">
                                            <tr class="custom_thead">
                                                <th>#</th>
                                                <th> الصنف</th>
                                                <th>الوحدة</th>
                                                <th>الكمية</th>
                                                <th>السعر</th>
                                                <th>الاجمالي</th>
                                                @if ($data->is_approved == 0)
                                                    <th>الاجراءت</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($supplier_with_order_details as $info)
                                                <tr id="item_card-{{ $info->id }}" style="display:show;">
                                                    <td>{{ $i }}</td>
                                                    <td>
                                                        @if (isset($info->item_cards->name))
                                                            {{ $info->item_cards->name }}<br>
                                                            @if ($info->item_type == 2)
                                                                pro - {{ $info->pro_date }}<br>
                                                                ex -{{ $info->ex_date }}
                                                            @endif
                                                        @else
                                                            <b style="color:red;">
                                                                تم حذفه من النظام
                                                            </b>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($info->is_master_uom == 0)
                                                            @if (isset($info->item_cards->retail_uom->name))
                                                                {{ $info->item_cards->retail_uom->name }}
                                                            @else
                                                                <b style="color:red;">
                                                                    تم حذفه من النظام
                                                                </b>
                                                            @endif
                                                        @else
                                                            @if (isset($info->item_cards->uom->name))
                                                                {{ $info->item_cards->uom->name }}
                                                            @else
                                                                <b style="color:red;">
                                                                    تم حذفه من النظام
                                                                </b>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{ $info->deliverd_quantity * 1 }}</td>
                                                    <td>{{ $info->unit_price * 1 }}</td>
                                                    <td>{{ $info->total_price * 1 }}</td>
                                                    @if ($data->is_approved == 0)
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modal-delete{{ $info->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            <!-- are you shue modal -->
                                                            <div class="modal fade" id="modal-delete{{ $info->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content bg-danger">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">تحذير</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>هل انت متاكد من عملية الحذف ؟</p>
                                                                        </div>
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button id="delete_item_card" type="button"
                                                                                value="{{ $info->id }}"
                                                                                data-dismiss="modal"
                                                                                class="btn btn-outline-light">متابعة
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-outline-light"
                                                                                data-dismiss="modal">الغاء</button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- end are you shue modal -->
                                                        </td>
                                                    @endif
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="card_title_center">
                                        <p class="btn btn-danger btn-sm">
                                            لاتوجد اصناف حاليا
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
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
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- are you shue modal -->
    <div class="modal fade" id="modal-delete{{ $data->id }}">
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
                    <form action="{{ route('supplier_orders.destroy', $data->id) }}" method="POST">
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
    <!-- add item cards modal -->
    <div class="modal fade" id="Add_item_cards">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة اصناف للفاتورة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="Add_item_model_body" style="background-color: white;color:black;">
                    <form role="form" action="{{ route('supplier_orders.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="supplier_with_order_id" value="{{ $data->id }}">
                        <input type="hidden" id="supplier_with_order_is_approved" value="{{ $data->is_approved }}">
                        <input type="hidden" id="ajax_get_uom_url" value="{{ route('supplier_orders.ajax_get_uom') }}">
                        <input type="hidden" id="ajax_add_uom_url" value="{{ route('supplier_orders.ajax_add_uom') }}">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" id="delete_item_card_url"
                            value="{{ route('supplier_orders.ajax_delete_item_card') }}">
                        <input type="hidden" id="approve_invoice" value="{{ route('supplier_orders.load_modal_approve_invoice') }}">
                        <input type="hidden" id="approve_invoice_now_url" value="{{ route('supplier_orders.approve_invoice_now') }}">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>الاصناف</label>
                                    <b class="start_item_card_id" style="color: red">*</b>
                                    <select class="form-control select2" name="item_card_id" id="item_card_id"
                                        style="width: 100%;">
                                        <option value="">اختر الصنف</option>
                                        @if (@isset($item_card) && !@empty($item_card))
                                            @foreach ($item_card as $info)
                                                <option data-type="{{ $info->item_type }}" value="{{ $info->id }}">
                                                    {{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 relatied_price_retial_counter">
                                <div class="form-group">
                                    <label>الكمية المستلمة</label>
                                    <b class="start_quantity" style="color: rgb(240, 43, 17);">*</b>
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" type="nubmer"
                                        name="quantity" id="quantity" value="" class="form-control"
                                        placeholder="ادخل الكمية المستلمة">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>الاجمالي</label>
                                    <b class="start_total" style="color: rgb(240, 43, 17);">*</b>
                                    <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" type="text"
                                        name="total" id="total" value="0" class="form-control"
                                        placeholder="0">
                                </div>
                            </div>
                            <div class="col-sm-4 pro_date" style="display: none;">
                                <div class="form-group">
                                    <label>تاريخ الانتاج</label>
                                    <b class="start_pro_date" style="color: rgb(240, 43, 17);">*</b>
                                    <input type="date" id="pro_date" name="pro_date" value=""
                                        class="form-control" placeholder="ادخل تاريخ انتاج الصنف">
                                </div>
                            </div>
                            <div class="col-sm-4 ex_date" style="display: none;">
                                <div class="form-group">
                                    <label>تاريخ انتهاء الصلاحية</label>
                                    <b class="start_ex_date" style="color: rgb(240, 43, 17);">*</b>
                                    <input type="date" id="ex_date" name="ex_date" value=""
                                        class="form-control" placeholder="ادخل تاريخ اتهاء صلاحية الصنف">
                                </div>
                            </div>
                            <div class="col-sm-4 DivUom">
                            </div>
                            <div class="col-sm-4 uom_price" style="display: none;">
                                <div class="form-group">
                                    <label>سعر الوحدة</label>
                                    <b class="start_price" style="color: rgb(240, 43, 17);">*</b>
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" type="number"
                                        name="price" id="price" value="" class="form-control"
                                        placeholder="ادخل سعر الوحدة">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 card_title_center">
                            <button type="submit" id="add_item_card" class="btn btn-sm btn-success">اضافة
                                للفاتورة</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <!--
                    <a href="" type="button" class="btn btn-outline-light">متابعة</a>
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">الغاء</button>
                        -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- end add item cards modal -->
    <!-- add do_close_approve_invoice modal -->
    <div class="modal fade" id="ModelApproveInvoice">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-info">
                <div class="modal-header">
                    <h4 class="modal-title">اعتماد وترحيل فاتورة المشتريات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ModelApproveInvoice_body" style="background-color: white;color:black;">      
                </div>
                <div class="modal-footer justify-content-between">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- end do_close_approve_invoice modal -->
@endsection
@section('script')
    <!-- general js -->
    <script src="{{ URL::asset('assets/admin/js/supplier_with_orders.js') }}"></script>
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
