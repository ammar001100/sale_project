@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    فئات الفواتير
@endsection
@section('pageTitle')
    فئات الفواتير
    <a type="button" href="{{ route('admin.sales_matrial_types.create') }}" class="btn btn-success btn-sm"><i
            class="fas fa-plus"></i></a>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li class="breadcrumb-item active">فئات الفواتير</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">بيانات فئات الفواتير</h3>
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
                                        <th>مسلسل</th>
                                        <th>اسم الفئة</th>
                                        <th>حالة التفعيل</th>
                                        <th>تاريخ الاضافة</th>
                                        <th>تاريخ التحديث</th>
                                        <th>الاجراءت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>
                                                @if ($info->active == 1)
                                                    مفعل
                                                @else
                                                    غير مفعل
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $dt = new DateTime($info->created_at);
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
                                                {{ $info->added_by_admin }}
                                            </td>
                                            <td>
                                                @if ($info['updated_by'] > 0 and $info['updated_by'] != null)
                                                    @php
                                                        $dt = new DateTime($info['updated_at']);
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
                                                    {{ $info->updated_by_admin }}
                                                @else
                                                    لا يوجد تحديث
                                                @endif
                                            <td>
                                                <a href="{{ route('admin.sales_matrial_types.edit', $info->id) }}"
                                                    class="btn btn-sm btn-info"> <i class="fas fa-pencil-alt"></i></a>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modal-danger{{ $info->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <!-- are you shue modal -->
                                                <div class="modal fade" id="modal-danger{{ $info->id }}">
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
                                                                <a href="{{ route('admin.sales_matrial_types.delete', $info->id) }}"
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
    <script src="{{ URL::asset('assets/admin/js/treasuries.js') }}"></script>
@endsection
