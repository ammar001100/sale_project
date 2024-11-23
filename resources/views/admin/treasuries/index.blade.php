@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
الخزن
@endsection
@section('pageTitle')
الخزن
<a type="button" href="{{ route('admin.treasuries.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></a>
@endsection
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
    <li class="breadcrumb-item active">الخزن</li>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>البحث</h5>
                <hr>
                <div class="row">
                    @if (isset($data) && $data->count() >= 3)

                    <div class="col-md-12">

                        <input type="text" id="search_by_text" class="form-control" placeholder="بحث بالاسم">

                    </div>
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.treasuries.ajax_search') }}">
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    @endif
                </div>


            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-2 card_body_style">
                <h5>بيانات الخزن</h5>
                <hr>
                <div id="ajax_responce_searchDiv">
                    @if (isset($data) && $data->count() > 0)
                    @php
                    $i = 1;
                    @endphp
                    <table class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <tr class="custom_thead">
                                <th>مسلسل</th>
                                <th>اسم الخزنة</th>
                                <th>نوع الخزنة</th>
                                <th>حالة التفعيل</th>
                                <th>اخر اصال صرف</th>
                                <th>اخر اصال تحصيل</th>
                                <th>الاجراءت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $info->name }}</td>
                                <td>
                                    @if ($info->is_master == 1)
                                    رئيسية
                                    @else
                                    فرعية
                                    @endif
                                </td>
                                <td>
                                    @if ($info->active == 1)
                                    مفعل
                                    @else
                                    غير مفعل
                                    @endif
                                </td>
                                <td>{{ $info->last_isal_exhcange }}</td>
                                <td>{{ $info->last_isal_collect }}</td>
                                <td>
                                    <a href="{{ route('admin.treasuries.edit', $info->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-pencil-alt"></i></a>
                                    <a href="{{ route('admin.treasuries.show', $info->id) }}" data-id="{{ $info->id }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i></a>
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
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/admin/js/treasuries.js') }}"></script>
@endsection
