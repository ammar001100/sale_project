@extends('admin.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection
@section('headTitle')
    الاصناف
@endsection
@section('pageTitle')
    الاصناف
    <a type="button" href="{{ route('item_cards.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></a>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li class="breadcrumb-item active">الاصناف</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">بيانات الاصناف</h3><br>
                    <div class="row">
                        @if (isset($data) && $data->count() >= 5)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="icheck-success d-inline">
                                        <input type="radio" value="barcode" name="r3" id="radio">
                                        <label for="radio">
                                        </label>
                                    </div>
                                    بحث بالباركود
                                    <div class="icheck-success d-inline">
                                        <input type="radio" value="item_code" name="r3" id="radio2">
                                        <label for="radio2">
                                        </label>
                                    </div>
                                    بحث بالكود
                                    <div class="icheck-success d-inline">
                                        <input type="radio" value="name" name="r3" id="radio1" checked>
                                        <label for="radio1">
                                        </label>
                                    </div>
                                    بحث بالاسم
                                </div>
                                <input type="text" id="search_by_text" class="form-control"
                                    placeholder="ادخل الباركود او الكود او الاسم">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div style="margin-bottom: 15px;">بحث بالنوع</div>
                                    <select class="custom-select" name="item_type_search" id="item_type_search">
                                        <option value="all">
                                            الكل
                                        </option>
                                        <option value="1">
                                            مخزني
                                        </option>
                                        <option value="2">
                                            استهلاكي بتاريخ صلاحية
                                        </option>
                                        <option value="3">
                                            عهدة
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div style="margin-bottom: 15px;">بحث بالفئة</div>
                                    <select class="custom-select" name="itemcard_category_id_search"
                                        id="itemcard_category_id_search">
                                        <option value="all">الكل</option>
                                        @if (@isset($Itemcard_categories) && !@empty($Itemcard_categories))
                                            @foreach ($Itemcard_categories as $info)
                                                <option @if (old('itemcard_category_id') == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="ajax_search_url" value="{{ route('item_cards.ajax_search') }}">
                            <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                            @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-2 card_body_style">
                    <div id="ajax_responce_searchDiv" class="">
                        @if (isset($data) && $data->count() > 0)
                            @php
                                $i = 1;
                            @endphp
                            <table class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <tr class="custom_thead">
                                        <th>#</th>
                                        <th>اسم الصنف</th>
                                        <th>نوع الصنف</th>
                                        <th>فئة الصنف</th>
                                        <th>الصنف الاب</th>
                                        <th>الوحدة الاب</th>
                                        <th>الوحدة التجزئة</th>
                                        <th>الاجراءت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>
                                                @if ($info->item_type == 1)
                                                    مخزني
                                                @elseif($info->item_type == 2)
                                                    استهلاكي بصلاحية
                                                @elseif($info->item_type == 3)
                                                    عهدة
                                                @else
                                                    غير محدد
                                                @endif
                                            </td>
                                            <td>{{ $info->itemcard_category->name }}</td>
                                            <td>
                                                @if ($info->item_card_id != 0)
                                                    @if (@isset($info->parent->name))
                                                        {{ $info->parent->name }}
                                                    @else
                                                        لا يوجد
                                                    @endif
                                                @else
                                                    صنف اب
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($info->uom->name))
                                                    {{ $info->uom->name }}
                                                @else
                                                    لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($info->retail_uom->name))
                                                    {{ $info->retail_uom->name }}
                                                @else
                                                    لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('item_cards.edit', $info->id) }}"
                                                    class="btn btn-sm btn-info"> <i class="fas fa-pencil-alt"></i></a>
                                                <a href="{{ route('item_cards.show', $info->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modal-delete{{ $info->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
                                                                <a href="{{ route('item_cards.destroy', $info->id) }}"
                                                                    type="button" class="btn btn-outline-light">متابعة</a>
                                                                <button type="button" class="btn btn-outline-light"
                                                                    data-dismiss="modal">الغاء</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- end are you shue modal -->
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
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
    <script src="{{ URL::asset('assets/admin/js/item_card_seaech.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ URL::asset('assets/admin/plugins/inputmask/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/moment/moment.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ URL::asset('assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}">
    </script>
@endsection
