@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    الضبط العام
@endsection
@section('pageTitle')
    الضبط العام
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الريئسية</a></li>
        <li class="breadcrumb-item active">الضبط العام</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">بيانات الشركة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body card_body_style">
                    @if (isset($data) && !empty($data))
                        <table id="example1" class="table table-bordered table-striped">
                            <tr>
                                <td class="width30">
                                    اسم الشركة
                                </td>
                                <td>
                                    {{ $data['system_name'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    كود الشركة
                                </td>
                                <td>
                                    {{ $data['com_code'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    حالة الشركة
                                </td>
                                <td>
                                    @if ($data['active'] == 1)
                                        مفعل
                                    @else
                                        غير مفعل
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    عنوان الشركة
                                </td>
                                <td>
                                    {{ $data['address'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    هاتف الشركة
                                </td>
                                <td>
                                    {{ $data['phone'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    التنبيه اعلى الشاشة للشركة
                                </td>
                                <td>
                                    {{ $data['general_alert'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    لوجو الشركة
                                </td>
                                <td class="image">
                                    <img class="custom_img"
                                        src="{{ asset('assets/admin/uploads/admin_sttings_imgs') . '/' . $data['photo'] }}">
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
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        لا يوجد تحديث
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    <a href="{{ route('admin.setting.general.edit') }}" class="btn btn-sm btn-info"><i
                                            class="fas fa-pencil-alt"></i></a>
                                </td>
                            </tr>
                        </table>
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
@endsection
