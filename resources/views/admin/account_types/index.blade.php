@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    انواع الحسابات المالية
@endsection
@section('pageTitle')
    انواع الحسابات المالية
    <!--<a type="button" href="{{ route('admin.stores.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></a>-->
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">الحسابات</li>
        <li class="breadcrumb-item active">انواع الحسابات المالية</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">بيانات انواع الحسابات المالية</h3>
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
                                        <th>اسم نوع الحساب</th>
                                        <th>حالة التفعيل</th>
                                        <th>هل يضاف من شاشة داخلية</th>
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
                                                @if ($info->relatedIternalAccounts == 1)
                                                    نعم يضاف من شاشة الحسابات المالية
                                                @else
                                                    لا ويضاف من شاشة الحسابات المالية
                                                @endif
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
