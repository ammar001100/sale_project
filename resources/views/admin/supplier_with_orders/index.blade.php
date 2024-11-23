@extends('admin.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ URL::asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('headTitle')
    فواتير المشتريات
@endsection
@section('pageTitle')
    فواتير المشتريات
    <a type="button" href="{{ route('supplier_orders.create') }}" class="btn btn-success btn-sm"><i
            class="fas fa-plus"></i></a>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">حركات مخزنية</li>
        <li class="breadcrumb-item active">فواتير المشتريات</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <!-- <h6 class=" card_title_center">بيانات فواتير المشتريات</h6><br> -->
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
                                <input type="text" id="search_by_text" class="form-control"
                                    placeholder="ادخل الكود الألي او كود أصل الشراء">
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
                            <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                            @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-2 card_body_style">
                    <div id="ajax_responce_searchDiv" class="">
                        @if (isset($data) && $data->count() > 0)
                            <table class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <tr class="custom_thead">
                                        <th>كود الفاتورة</th>
                                        <th>المورد</th>
                                        <th>نوع الفاتورة</th>
                                        <th>حالة الفاتورة</th>
                                        <th>سعر الفاتورة</th>
                                        <th>تاريخ الفاتورة</th>
                                        <th>الاجراءت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $info->auto_serial }}</td>
                                            <td>
                                                @if (isset($info->supplier->name))
                                                    {{ $info->supplier->name }}
                                                @else
                                                    غير موجود
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
                                                @if ($info->is_approved == 1)
                                                    <b style="color: green">معتمدة</b>
                                                @else
                                                    <b style="color: red">مفتوحة</b>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $info->total_cost * 1 }}
                                            </td>
                                            <td>
                                                {{ $info->order_date }}
                                            </td>
                                            <td>
                                                <a href="{{ route('supplier_orders.show', $info->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    التفاصيل
                                                </a>
                                                @if ($info->is_approved == 0)
                                                    <a href="{{ route('supplier_orders.edit', $info->id) }}"
                                                        class="btn btn-sm btn-info"> <i class="fas fa-pencil-alt"></i></a>                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#modal-delete{{ $info->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                                <!-- are you shue modal -->
                                                <div class="modal fade" id="modal-delete{{ $info->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content bg-danger">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">تحذير</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>هل انت متاكد من عملية الحذف ؟</p>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <form
                                                                    action="{{ route('supplier_orders.destroy', $info->id) }}"
                                                                    method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-outline-light">متابعة</button>
                                                                    <button type="button" class="btn btn-outline-light"
                                                                        data-dismiss="modal">الغاء</button>
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
@endsection
@section('script')
    <script src="{{ URL::asset('assets/admin/js/supplier_with_orders.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/supplier_with_orders_seaech.js') }}"></script>
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
