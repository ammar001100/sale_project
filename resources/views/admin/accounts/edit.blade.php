@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
تعديل حساب مالي
@endsection
@section('pageTitle')
تعديل الحساب المالي {{ $data->name }}
@endsection
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item">الحسابات المالية</li>
    <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">الحسابات المالية</a></li>
    <li class="breadcrumb-item active">تعديل</li>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card p-3">
            <div class="card-header card_header_style">
                <h3 class="card-title card_title_center">تعديل حساب مالي </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form role="form" action="{{ route('accounts.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input name="page_name" id="page_name" value="account_edit" hidden>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>اسم الحساب المالي</label>
                                @if (old('name', $data->name) == '' or $errors->has('name, $data->name'))
                                <b class="start_name" style="color: rgb(240, 43, 17);">*</b>
                                @endif
                                <input type="text" name="name" id="name" value="{{ old('name', $data->name) }}" class="form-control" placeholder="ادخل اسم الصنف">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>نوع الحساب المالي</label>
                                @if (old('account_type_id', $data->account_type_id) == '' or $errors->has('account_type_id', $data->account_type_id))
                                <b class="start_account_type" style="color: rgb(240, 43, 17);">*</b>
                                @endif
                                <select class="custom-select" name="account_type_id" id="account_type_id" @if (old('account_type_id', $data->account_type_id) == 3) disabled @else '' @endif>
                                    <option value="">اختر النوع</option>
                                    @if (@isset($account_type) && !@empty($account_type))
                                    @foreach ($account_type as $info)
                                    <option @if (old('account_type_id', $data->account_type_id) == $info->id) selected @else '' @endif
                                        value="{{ $info->id }}">{{ $info->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>حالة الرصيد اول المدة</label>
                                @if (old('start_balance_status', $data->start_balance_status) == '' or
                                $errors->has('start_balance_status', $data->start_balance_status))
                                <b class="start_start_balance_status" style="color: rgb(240, 43, 17);">*</b>
                                @endif
                                <select class="custom-select" name="start_balance_status" id="start_balance_status" disabled>
                                    <option value="">
                                        اختر الحالة
                                    </option>
                                    <option @if (old('start_balance_status', $data->start_balance_status) == '2') selected @else '' @endif value="2">
                                        مدين
                                    </option>
                                    <option @if (old('start_balance_status', $data->start_balance_status) == '1') selected @else '' @endif value="1">
                                        دائن
                                    </option>
                                    <option @if (old('start_balance_status', $data->start_balance_status) == '3' and
                                        (old('start_balance_status', $data->start_balance_status) == '3') != '') selected @else '' @endif value="3">
                                        متزن
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>رصيد اول مدة</label>
                                @if (old('start_balance', $data->start_balance) == '' and
                                old('start_balance_status', $data->start_balance_status) != '3' or
                                $errors->has('start_balance', $data->start_balance))
                                <b class="start_start_balance" style="color: rgb(240, 43, 17);">*</b>
                                @endif
                                <div class="start_balanceDiv1" @if (old('start_balance_status', $data->start_balance_status) != 3) '' @else style="display: none;" @endif>
                                    <input type="text" oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="start_balance" id="start_balance" value="{{ old('start_balance', $data->start_balance) }}" class="form-control" placeholder="ادخل المبلغ بدون سالب" disabled>
                                </div>
                                <div class="start_balanceDiv2" @if (old('start_balance_status', $data->start_balance_status) == 3) '' @else style="display: none;" @endif>
                                    <input name="start_balance" class="form-control" value="0.00" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>هل الحساب رئيسي</label>
                                @if (old('is_parent', $data->is_parent) == '' or $errors->has('is_parent', $data->is_parent))
                                <b class="start_is_parent" style="color: rgb(240, 43, 17);">*</b>
                                @endif
                                <select class="custom-select" name="is_parent" id="is_parent">
                                    <option value="">
                                        اختر الحالة
                                    </option>
                                    <option @if (old('is_parent', $data->is_parent) == '0' and (old('is_parent', $data->is_parent) == '0') != '') selected @else '' @endif
                                        value="0">
                                        رئيسي
                                    </option>
                                    <option @if (old('is_parent', $data->is_parent) == '1') selected @else '' @endif value="1">
                                        فرعي
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 parentDiv" @if (old('is_parent', $data->is_parent) == 1) '' @else style="display: none;" @endif>
                            <div class="form-group">
                                <label>الحساب الرئيسي</label>
                                @if (old('account_id', $data->account_id) == '' or $errors->has('account_id', $data->account_id))
                                <b class="start_account" style="color: rgb(240, 43, 17);">*</b>
                                @endif
                                <select class="custom-select" name="account_id" id="account_id">
                                    <option value="">اختر الحساب الذي يتبع له</option>
                                    @if (@isset($parent_account) && !@empty($parent_account))
                                    @foreach ($parent_account as $info)
                                    <option @if (old('account_id', $data->account_id) == $info->id) selected @else '' @endif
                                        value="{{ $info->id }}">{{ $info->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>حالة الأرشفة</label>
                                @if (old('is_archived', $data->is_archived) == '' or $errors->has('is_archived', $data->is_archived))
                                <b class="start_is_archived" style="color: rgb(240, 43, 17);">*</b>
                                @endif
                                <select class="custom-select" name="is_archived" id="is_archived">
                                    <option value="">
                                        اختر الحالة
                                    </option>
                                    <option @if (old('is_archived', $data->is_archived) == '1') selected @else '' @endif
                                        value="1">
                                        مؤرشف
                                    </option>
                                    <option @if (old('is_archived', $data->is_archived) == '0' and (old('is_archived', $data->is_archived) == '0') != '') selected @else '' @endif
                                        value="0">
                                        غير مؤرشف
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ملاحظات</label>
                                @if (old('notes', $data->notes) == '' or $errors->has('notes', $data->notes))
                                <b class="start_notes" style="color: rgb(240, 43, 17);"></b>
                                @endif
                                <input type="text" name="notes" id="notes" value="{{ old('notes', $data->notes) }}" class="form-control" placeholder="ادخل الملاحظات">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card_title_center">
                <button id="do_add_accounts" type="submit" class="btn btn-success">تحديث</button>
                <a href="{{ route('accounts.index') }}" type="button" class="btn btn-danger">الغاء</a>
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
<script src="{{ URL::asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ URL::asset('assets/admin/js/accounts_validation.js') }}"></script>
<script src="{{ URL::asset('assets/admin/js/accounts.js') }}"></script>
@endsection
