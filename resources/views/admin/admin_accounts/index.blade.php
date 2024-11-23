@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    المستخدمين
@endsection
@section('pageTitle')
    المستخدمين
    <a type="button" href="{{ route('admin_accounts.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></a>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">الصلاحيات</li>
        <li class="breadcrumb-item active">المستخدمين</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">بيانات المستخدمين</h3>
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
                                        <th>اسم المستخدم</th>
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
                                                <a href="{{ route('admin_accounts.edit', $info->id) }}"
                                                    class="btn btn-sm btn-info"> <i class="fas fa-pencil-alt"></i></a>
                                                <a href="{{ route('admin_accounts.show', $info->id) }}"
                                                    class="btn btn-sm btn-primary"> <i class="fas fa-eye"></i></a>
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#modal-show{{ $info->id }}">
                                                    تفاصيل
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modal-delete{{ $info->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <!-- show modal -->
                                                <div class="modal fade" id="modal-show{{ $info->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content bg-default">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">تفاصيل مخزن -
                                                                    {{ $info->name }}</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table id="example1"
                                                                    class="table table-bordered table-striped">
                                                                    <tr>
                                                                        <td class="width30">
                                                                            ارقام الهواتف
                                                                        </td>
                                                                        <td>
                                                                            {{ $info->phones }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="width30">
                                                                            العنوان
                                                                        </td>
                                                                        <td>
                                                                            {{ $info->address }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">الغاء</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- end show modal -->
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
                                                                <a href="{{ route('admin_accounts.destroy', $info->id) }}"
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
