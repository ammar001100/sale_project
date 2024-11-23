@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    شفتات خزن المستخدمين
@endsection
@section('pageTitle')
    شفتات خزن المستخدمين
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">حركات شفت الخزينة</li>
        <li class="breadcrumb-item"><a href="{{ route('admin_shifts.index') }}">شفتات خزن المستخدمين</a></li>
        <li class="breadcrumb-item active">اضافة</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">اختيار خزنة لبدء شفت جديد</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('admin_shifts.store') }}" method="POST">
                        @csrf
                        <div class="row">
                        <div class="col-sm-12">
                                <div class="form-group">
                                    <label>الخزن</label>
                                    @if (old('treasury_id') == '' or $errors->has('treasury_id'))
                                        <b class="start_treasury_id" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="treasury_id" id="treasury_id">
                                        <option value="">اختر الخزنة لبدء الشفت</option>
                                        @if (@isset($treasuries) && !@empty($treasuries))
                                            @foreach ($treasuries as $info)
                                                <option @if($info->is_finished == 1 )
                                                     style="color:red;" disabled
                                                     @else
                                                     style="color:green;"
                                                     @endif
                                                    value="
                                                    @if($info->treasury->id)
                                                    {{ $info->treasury->id }}
                                                    @else '' 
                                                    @endif
                                                    ">
                                                    @if($info->treasury->name)
                                                    @if($info->is_finished == 1 )
                                                    {{ $info->treasury->name }}(مشغول)
                                                     @else
                                                     {{ $info->treasury->name }}( متاح)
                                                     @endif
                                                    @else
                                                    لا يوجد ربما تم حذفه 
                                                    @endif
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card_title_center">
                    <button type="submit" class="btn btn-success">اضافة</button>
                    <a href="{{ route('admin_shifts.index') }}" type="button" class="btn btn-danger">الغاء</a>
                </div>
            </div>
            </form>
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
@endsection
