@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    شفتات خزن المستخدمين
@endsection
@section('pageTitle')
    شفتات خزن المستخدمين
    @if(empty($is_finished))
    <a type="button" href="{{ route('admin_shifts.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></a>
    @endif
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">حركات شفت الخزينة</li>
        <li class="breadcrumb-item active">شفتات خزن المستخدمين</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">بيانات شفتات خزن المستخدمين</h3><br>
                    <div class="row">
                        @if (isset($data) && $data->count() >= 3)
                            <div class="col-md-6">
                                <input type="text" id="search_by_text" class="form-control" placeholder="بحث بالاسم">
                            </div>
                            <div class="col-md-6">
                                <select class="custom-select" name="is_master_search" id="is_master_search">
                                    <option value="all">
                                        بحث بالوحدة
                                    </option>
                                    <option value="1">
                                        وحدة اب
                                    </option>
                                    <option value="0">
                                        وحدة تجزئة
                                    </option>
                                </select>
                                <input type="hidden" id="ajax_search_url" value="{{ route('admin_shifts.ajax_search') }}">
                                <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                            </div>
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
                                        <th>رقم الشفت</th>
                                        <th>اسم المستخدم</th>
                                        <th>اسم الخزنة </th>
                                        <th>توقيت الفتح </th>
                                        <th>حالة الانتهاء</th>
                                        <th>حالة المراجعة</th>
                                        <th>الاجراءت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $info->shift_code }}</td>
                                            <td>
                                                @if (isset($info->admin->name))
                                                     {{ $info->admin->name }}
                                                @else
                                                     لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                            @if (isset($info->treasury->name))
                                                     {{ $info->treasury->name }}
                                                @else
                                                     لا يوجد
                                                @endif
                                            </td>
                                            <td>
                                            @php
                                                    $dt = new DateTime($info->start_date);
                                                    $date = $dt->format('Y-m-d');
                                                    $time = $dt->format('H:i');
                                                    $newDateTime = date('A', strtotime($time));
                                                    $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساء';
                                                @endphp
                                                {{ $date }}
                                                <br>
                                                {{ $time }}
                                                {{ $newDateTimeType }}
                                            </td>
                                            <td>
                                            @if ($info->is_finished == 1)
                                                     <b style="color:green">مفتوح</b>
                                                @else
                                                <b style="color:red">مغلق</b>
                                                @endif
                                            </td>
                                            <td>
                                            @if ($info->is_delivered == 1)
                                                     <b style="color:green">تم المراجعة</b>
                                                @else
                                                <b style="color:red">غير مراجع</b>
                                                @endif
                                            <td>
                                                <a href="{{ route('admin_shifts.edit', $info->id) }}"
                                                    class="btn btn-sm btn-primary"> <i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('admin_shifts.edit', $info->id) }}"
                                                    class="btn btn-sm btn-warning"><i class="fas fa-print"></i></a>
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
    <script src="{{ URL::asset('assets/admin/js/admin_shifts.js') }}"></script>
@endsection
