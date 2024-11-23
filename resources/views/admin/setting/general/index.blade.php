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
                        <td class="table_td1">
                            اسم الشركة
                        </td>
                        <td class="table_td2">
                            {{ $data['system_name'] }}
                        </td>
                        <td class="table_td1">
                            كود الشركة
                        </td>
                        <td class="table_td2">
                            {{ $data['com_code'] }}
                        </td>
                        <td class="table_td1">
                            حالة الشركة
                        </td>
                        <td class="table_td2">
                            @if ($data['active'] == 1)
                            مفعل
                            @else
                            غير مفعل
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="table_td1">
                            عنوان الشركة
                        </td>
                        <td class="table_td2">
                            {{ $data['address'] }}
                        </td>
                        <td class="table_td1">
                            هاتف الشركة
                        </td>
                        <td class="table_td2">
                            {{ $data['phone'] }}
                        </td>
                        <td class="table_td1">
                            التنبيه اعلى الشاشة للشركة
                        </td>
                        <td class="table_td2">
                            {{ $data['general_alert'] }}
                        </td>
                    </tr>
                    <tr>
                        <td class="table_td1" colspan="1">
                            الحساب الرئيسي للعملاء في الشجرة المحاسبية
                        </td>
                        <td class="table_td2">
                            @if (isset($data->customer_parent_account->name))
                            {{ $data->customer_parent_account->name }} - الحساب رقم
                            ({{ $data->customer_parent_account->account_number }})
                            @else
                            لا يوجد
                            @endif
                        </td>
                        <td class="table_td1">
                            الحساب الرئيسي الموردين في الشجرة المحاسبية
                        </td>
                        <td class="table_td2">
                            @if (isset($data->supplier_parent_account->name))
                            {{ $data->supplier_parent_account->name }} - الحساب رقم
                            ({{ $data->supplier_parent_account->account_number }})
                            @else
                            لا يوجد
                            @endif
                        </td>
                        <td class="table_td1" colspan="1">
                            الحساب الرئيسي للمناديب في الشجرة المحاسبية
                        </td>
                        <td class="table_td2">
                            @if (isset($data->delegate_parent_account->name))
                            {{ $data->delegate_parent_account->name }} - الحساب رقم
                            ({{ $data->delegate_parent_account->account_number }})
                            @else
                            لا يوجد
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="table_td1" colspan="1">
                            الحساب الرئيسي للموظفين في الشجرة المحاسبية
                        </td>
                        <td class="table_td2">
                            @if (isset($data->employee_parent_account_id->name))
                            {{ $data->employee_parent_account_id->name }} - الحساب رقم
                            ({{ $data->employee_parent_account_id->account_number }})
                            @else
                            لا يوجد
                            @endif
                        </td>
                        <td class="table_td1">
                            تاريخ اخر تحديث
                        </td>
                        <td class="table_td2">
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
                        <td class="table_td1"></td>
                        <td class="table_td2"></td>

                    </tr>
                    <tr>
                        <td class="table_td1">
                            لوجو الشركة
                        </td>
                        <td colspan="5" class="image table_td2" style="border: solid 1px #9290e7;margin: 10px;background: #f0f0f3;">
                            <img class="custom_img" src="{{ asset('assets/admin/uploads/admin_sttings_imgs') . '/' . $data['photo'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="table_td2">
                            <a href="{{ route('admin.setting.general.edit') }}" class="btn btn-sm btn-info card_button_style">تعديل <i class="fas fa-pencil-alt"></i></a>
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
