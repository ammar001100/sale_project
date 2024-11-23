@extends('admin.layouts.app')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ URL::asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('headTitle')
    شاشة تحصيل النقدية
@endsection
@section('pageTitle')
    شاشة تحصيل النقدية
   <!-- <a type="button" href="{{ route('collect_transactions.create') }}" class="btn btn-success btn-sm"><i
            class="fas fa-plus"></i></a>-->
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">الحسابات المالية</li>
        <li class="breadcrumb-item active">شاشة تحصيل النقدية</li>
    </ol>
@endsection
@section('content')


<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">شاشة التحصيل</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="ajax_responce_searchDiv" class="">
                    <form role="form" action="{{ route('collect_transactions.store') }}" method="POST"
                        enctype="multipart/form-data" style="
                        background-color:;">
                        @csrf
                        <div class="row">
                        <div class="col-sm-4">
                                <div class="form-group">
                                    <label>تاريخ الحركة</label>
                                    @if (old('mov_date') == '' or $errors->has('mov_date'))
                                        <b class="start_mov_date" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input type="date" id="mov_date" name="mov_date" value="{{ old('mov_date') }}"
                                        class="form-control" placeholder="ادخل تاريخ الحركة">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>الحساب المالي</label>
                                    @if (old('account_id') == '' or $errors->has('account_id'))
                                        <b class="start_account_id" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="form-control select2" name="account_id" id="account_id">
                                        <option value="">اختر الحساب المالي</option>
                                        @if (@isset($account) && !@empty($account))
                                            @foreach ($account as $info)
                                                <option data-type="{{ $info->account_type->id }}" @if (old('account_id') == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}"
                                                    data-account_state="{{ $info->start_balance_status }}">{{ $info->name }} ({{ $info->account_type->name }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                <label>
                                         حالة الحساب المالي
                                    </label>
                                    <input id="account_state" disabled value="" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>
                                         قيمة المبلغ المحصل
                                    </label>
                                    @if (old('money') == '' or $errors->has('money'))
                                        <b class="start_money" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        type="text" name="money"
                                        id="money" value="{{ old('money') }}" class="form-control"
                                        placeholder="ادخل قيمة المبلغ المحصل">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>
                                           الرصيد المتاح بالخزنة
                                    </label>
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        type="text" name="money" value="{{ $money * 1 }}"  class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>الخزنة</label>
                                    <select class="custom-select" name="treasury_id" radonly>
                                        <option value="{{ $admin_shift->treasury->id }}">{{ $admin_shift->treasury->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>نوع الحركة المالية</label>
                                    @if (old('mov_type_id') == '' or $errors->has('mov_type_id'))
                                        <b class="start_mov_type_id" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="form-control" name="mov_type_id" id="mov_type_id">
                                        <option value="">اختر نوع الحركة المالية</option>
                                        @if (@isset($mov_type) && !@empty($mov_type))
                                            @foreach ($mov_type as $info)
                                                <option @if (old('mov_type_id') == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>البيان</label>
                                    <textarea type="text" name="byan" id="byan" class="form-control">{{ old('mov_type_id','تحصيل نظير ') }}</textarea>
                                </div>
                            </div>
                            <div class="card_title_center">
                    <button id="add_item_card" type="submit" class="btn btn-success">تحصيل</button>
                </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">بيانات حركة تحصيل النقدية</h3>
                    @if (isset($data) && $data->count() >= 3)
                        <div class="col-md-12">
                            <input type="text" id="search_by_text" class="form-control" placeholder="بحث بالاسم">
                        </div>
                        <input type="hidden" id="ajax_search_url" value="{{ route('collect_transactions.ajax_search') }}">
                        <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0 card_body_style">
                    <div id="ajax_responce_searchDiv" class="">
                        @if (isset($data) && $data->count() > 0)
                            <table class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <tr class="custom_thead">
                                        <th>رقم الاصال</th>
                                        <th>كود الاصال</th>
                                        <th>نوع الحركة المالية</th>
                                        <th> الخزنة</th>
                                        <th>المبلغ</th>
                                        <th>البيان</th>
                                        <th> الانشاء</th>
                                        <th>الاجراءت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{  $info->auto_serial }}</td>
                                            <td>{{ $info->trans_code }}</td>
                                            <td>
                                            @if(isset($info->mov_type->name))
                                                {{ $info->mov_type->name }}
                                                @else
                                                لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                            @if(isset($admin_shift->treasury->name))
                                                {{ $admin_shift->treasury->name }}
                                                @else
                                                لا يوجد
                                                @endif
                                            </td>
                                            <td>{{ $info->money * 1 }}</td>
                                            <td>{{ $info->byan }}</td>
                                            <td>
                                                    @php
                                                        $dt = new DateTime($info['created_at']);
                                                        $date = $dt->format('Y-m-d');
                                                        $time = $dt->format('H:i');
                                                        $newDateTime = date('A', strtotime($time));
                                                        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساء';
                                                    @endphp
                                                    {{ $date }}
                                                    <br>
                                                    {{ $time }}
                                                    {{ $newDateTimeType }}<br>
                                                    بواسطة :
                                                    @if(isset($admin_shift->admin->name))
                                                {{ $admin_shift->admin->name }}
                                                @else
                                                لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('collect_transactions.edit', $info->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    طباعة</a>
                                                <a href="{{ route('collect_transactions.show', $info->id) }}"
                                                    data-id="{{ $info->id }}" class="btn btn-sm btn-primary">
                                                    عرض</a>
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
    <script src="{{ URL::asset('assets/admin/js/collect_transactions.js') }}"></script>
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
