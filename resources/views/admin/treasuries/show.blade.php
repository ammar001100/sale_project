@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    تفاصيل الخزنة
@endsection
@section('pageTitle')
    تفاصيل الخزنة ({{ $data->name }})
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الريئسية</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.treasuries') }}">الخزن</a></li>
        <li class="breadcrumb-item active">تفاصيل الخزنة </li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">تفاصيل الخزنة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body card_body_style">
                    @if (isset($data) && $data->count() > 0)
                        <table id="example1" class="table table-bordered table-striped">
                            <tr>
                                <td class="width30">
                                    اسم الخزنه
                                </td>
                                <td>
                                    {{ $data->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    أخر اصال صرف
                                </td>
                                <td>
                                    {{ $data->last_isal_exhcange }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    أخر اصال تحصيل
                                </td>
                                <td>
                                    {{ $data->last_isal_collect }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    حالة تفعيل الخزنه
                                </td>
                                <td>
                                    @if ($data->active == 1)
                                        مفعل
                                    @else
                                        غير مفعل
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    نوع الخزنه
                                </td>
                                <td>
                                    @if ($data->is_master == 1)
                                        رئيسيه
                                    @else
                                        فرعيه
                                    @endif
                                </td>
                            </tr>
                            <tr>
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
                                    <a href="{{ route('admin.treasuries.edit', $data->id) }}"
                                        class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a></a>
                                    <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        </table>

                        <div class="card-header card_header_style">
                            <h3 class="card-title card_title_center">الخزن الفرعية التي سوف تسلم عهدتها الى الخزنة
                                ({{ $data->name }}) <a type="button"
                                    href="{{ route('admin.treasuries.add_treasuries_delivery', $data->id) }}"
                                    class="btn btn-success btn-sm"><i class="fas fa-plus"></i></a></h3>
                        </div>
                        <div class="card-body table-responsive p-2 card_body_style">
                            <div id="ajax_responce_searchDiv">
                                @if (isset($treasuries_delivery) && $treasuries_delivery->count() > 0)
                                    @php
                                        $i = 1;
                                    @endphp
                                    <table class="table table-bordered table-hover">
                                        <thead class="custom_thead">
                                            <tr class="custom_thead">
                                                <th>مسلسل</th>
                                                <th>اسم الخزنة</th>
                                                <th>تاريخ الأضافة</th>
                                                <th>الاجراءت</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($treasuries_delivery as $info)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $info->name }}</td>
                                                    <td>
                                                        @php
                                                            $dt = new DateTime($info->created_at);
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
                                                        {{ $data->admin->name }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal" data-target="#modal-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <!-- are you shue modal -->
                                                        <div class="modal fade" id="modal-danger">
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
                                                                        <a href="{{ route('admin.treasuries.delete_treasuries_delivery', $info->id) }}"
                                                                            type="button"
                                                                            class="btn btn-outline-light">متابعة</a>
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
                                @else
                                    <div class="card_title_center">
                                        <p class="btn btn-danger btn-sm">
                                            عفوا لاتوجد بيانات
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
@endsection
@section('script')
    <!-- general js -->
    <script src="{{ URL::asset('assets/admin/js/general.js') }}"></script>
@endsection
