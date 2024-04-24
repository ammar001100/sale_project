@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    اضافة صنف
@endsection
@section('pageTitle')
    اضافة صنف
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li class="breadcrumb-item"><a href="{{ route('item_cards.index') }}">الاصناف</a></li>
        <li class="breadcrumb-item active">اضافة</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">اضافة صنف جديدة</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form role="form" action="{{ route('item_cards.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>باركود الصنف -
                                        <small style="color: rgb(240, 43, 17);">
                                            في حالة عدم الادخال سيولد بشكل ألي
                                        </small>
                                    </label>
                                    <input type="text" name="barcode" id="barcode_ceate" value="{{ old('barcode') }}"
                                        class="form-control" placeholder="ادخل باركود الصنف">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>اسم الصنف</label>
                                    @if (old('name') == '' or $errors->has('name'))
                                        <b class="start_name" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="form-control" placeholder="ادخل اسم الصنف">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>نوع الصنف</label>
                                    @if (old('item_type') == '' or $errors->has('item_type'))
                                        <b class="start_item_type" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="item_type" id="item_type">
                                        <option value="">
                                            اختر نوع الصنف
                                        </option>
                                        <option @if (old('item_type') == 1) selected @else '' @endif value="1">
                                            مخزني
                                        </option>
                                        <option @if (old('item_type') == 2) selected @else '' @endif value="2">
                                            استهلاكي بتاريخ صلاحية
                                        </option>
                                        <option @if (old('item_type') == 3) selected @else '' @endif value="3">
                                            عهدة
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>فئة الصنف</label>
                                    @if (old('itemcard_category_id') == '' or $errors->has('itemcard_category_id'))
                                        <b class="start_itemcard_category_id" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="itemcard_category_id" id="itemcard_category_id">
                                        <option value="">اختر الفئة</option>
                                        @if (@isset($Itemcard_categories) && !@empty($Itemcard_categories))
                                            @foreach ($Itemcard_categories as $info)
                                                <option @if (old('itemcard_category_id') == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>وحدة القياس الاب</label>
                                    @if (old('uom_id') == '' or $errors->has('uom_id'))
                                        <b class="start_uom_id" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="uom_id" id="uom_id">
                                        <option value="">اختر وحدة القياس الاب</option>
                                        @if (@isset($uoms) && !@empty($uoms))
                                            @foreach ($uoms as $info)
                                                <option @if (old('uom_id') == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_parent_counter"
                                @if (old('uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: rgb(128, 0, 79);">هل للصنف وحدة تجزئة فرعية</label>
                                    @if (old('does_has_retailunit') == '' or $errors->has('does_has_retailunit'))
                                        <b class="start_does_has_retailunit" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select style="background: rgb(231, 206, 219);" class="custom-select"
                                        name="does_has_retailunit" id="does_has_retailunit">
                                        <option value="">
                                            اختر الحالة
                                        </option>
                                        <option @if (old('does_has_retailunit') == 1) selected @else '' @endif value="1">
                                            نعم
                                        </option>
                                        <option @if (old('does_has_retailunit') == '0' and (old('does_has_retailunit') == '0') != '') selected  @else '' @endif value="0">
                                            لا
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_parent_counter"
                                @if (old('uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: rgb(10, 8, 151);">
                                        سعر القطاعي بوحدة
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="parent_uom_name"></span></small>
                                    </label>
                                    @if (old('price') == '' or $errors->has('price'))
                                        <b class="start_price" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        style="background: rgb(201, 200, 238);" type="text" name="price" id="price"
                                        value="{{ old('price') }}" class="form-control" placeholder="ادخل السعر">
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_parent_counter"
                                @if (old('uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: rgb(10, 8, 151);">
                                        السعر نص جملة بوحدة
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="parent_uom_name"></span></small>
                                    </label>
                                    @if (old('nos_gomal_price') == '' or $errors->has('nos_gomal_price'))
                                        <b class="start_nos_gomal_price" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        style="background: rgb(201, 200, 238);" type="text" name="nos_gomal_price"
                                        id="nos_gomal_price" value="{{ old('nos_gomal_price') }}" class="form-control"
                                        placeholder="ادخل السعر">
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_parent_counter"
                                @if (old('uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: rgb(10, 8, 151);">
                                        السعر الجملة بوحدة
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="parent_uom_name"></span></small>
                                    </label>
                                    @if (old('gomal_price') == '' or $errors->has('gomal_price'))
                                        <b class="start_gomal_price" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        style="background: rgb(201, 200, 238);" type="text" name="gomal_price"
                                        id="gomal_price" value="{{ old('gomal_price') }}" class="form-control"
                                        placeholder="ادخل السعر">
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_parent_counter"
                                @if (old('uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: rgb(10, 8, 151);">
                                        سعر الشراء بوحدة
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="parent_uom_name"></span></small>
                                    </label>
                                    @if (old('cost_price') == '' or $errors->has('cost_price'))
                                        <b class="start_nos_gomal_price" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        style="background: rgb(201, 200, 238);" type="text" name="cost_price"
                                        id="cost_price" value="{{ old('cost_price') }}" class="form-control"
                                        placeholder="ادخل السعر">
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_retial_counter"
                                @if (old('does_has_retailunit') == 1) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: green;">
                                        وحدة قياس التجزئة للوحدة الاب
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="parent_uom_name"></span></small>
                                    </label>
                                    @if (old('retail_uom_id') == '' or $errors->has('retail_uom_id'))
                                        <b class="start_retail_uom_id" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select style="background: rgb(206, 231, 206);" class="custom-select"
                                        name="retail_uom_id" id="retail_uom_id">
                                        <option value="">اختر وحدة القياس الجزئية</option>
                                        @if (@isset($retail_uoms) && !@empty($retail_uoms))
                                            @foreach ($retail_uoms as $info)
                                                <option @if (old('retail_uom_id') == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_price_retial_counter"
                                @if (old('retail_uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: green;">
                                        عدد وحدات التجزئة
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="child_uom_name"></span></small>
                                        للوحدة الاب
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="parent_uom_name"></span></small>
                                    </label>
                                    @if (old('retail_uom_quntToparent') == '' or $errors->has('retail_uom_quntToparent'))
                                        <b class="start_retail_uom_quntToparent" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        style="background: rgb(206, 231, 206);" type="text"
                                        name="retail_uom_quntToparent" id="retail_uom_quntToparent"
                                        value="{{ old('retail_uom_quntToparent') }}" class="form-control"
                                        placeholder="ادخل عدد وحدات التجزئة ">
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_price_retial_counter"
                                @if (old('retail_uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: rgb(161, 163, 33);">
                                        سعر القطاعي بوحدة
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="child_uom_name"></span></small>
                                    </label>
                                    @if (old('price_retail') == '' or $errors->has('price_retail'))
                                        <b class="start_price_retail" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        style="background: rgb(226, 238, 200);" type="text" name="price_retail"
                                        id="price_retail" value="{{ old('price_retail') }}" class="form-control"
                                        placeholder="ادخل السعر">
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_price_retial_counter"
                                @if (old('retail_uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: rgb(161, 163, 33);">
                                        سعر نص جملة بوحدة
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="child_uom_name"></span></small>
                                    </label>
                                    @if (old('nos_gomal_price_retail') == '' or $errors->has('nos_gomal_price_retail'))
                                        <b class="start_nos_gomal_price_retail" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        style="background: rgb(226, 238, 200);" type="text"
                                        name="nos_gomal_price_retail" id="nos_gomal_price_retail"
                                        value="{{ old('nos_gomal_price_retail') }}" class="form-control"
                                        placeholder="ادخل السعر">
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_price_retial_counter"
                                @if (old('retail_uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: rgb(161, 163, 33);">
                                        سعر الجملة بوحدة
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="child_uom_name"></span></small>
                                    </label>
                                    @if (old('gomal_price_retail') == '' or $errors->has('gomal_price_retail'))
                                        <b class="start_gomal_price_retail" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        style="background: rgb(226, 238, 200);" type="text" name="gomal_price_retail"
                                        id="gomal_price_retail" value="{{ old('gomal_price_retail') }}"
                                        class="form-control" placeholder="ادخل السعر">
                                </div>
                            </div>
                            <div class="col-sm-6 relatied_price_retial_counter"
                                @if (old('retail_uom_id') > 0) '' @else style="display: none;" @endif>
                                <div class="form-group">
                                    <label style="color: rgb(161, 163, 33);">
                                        سعر الشراء بوحدة
                                        <small><span style="color: rgb(64, 23, 212);"
                                                class="child_uom_name"></span></small>
                                    </label>
                                    @if (old('cost_price_retail') == '' or $errors->has('cost_price_retail'))
                                        <b class="start_cost_price_retail" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        style="background: rgb(226, 238, 200);" type="text" name="cost_price_retail"
                                        id="cost_price_retail" value="{{ old('cost_price_retail') }}"
                                        class="form-control" placeholder="ادخل السعر">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>الصنف الرئسي اذا كان فرعي</label>
                                    @if (old('item_card_id') == '' or $errors->has('item_card_id'))
                                        <b class="start_item_card_id" style="color: rgb(240, 43, 17);"></b>
                                    @endif
                                    <select class="custom-select" name="item_card_id" id="item_card_id">
                                        <option value="0">صنف رئسي</option>
                                        @if (@isset($child_item_cards) && !@empty($child_item_cards))
                                            @foreach ($child_item_cards as $info)
                                                <option @if (old('item_card_id') == $info->id) selected @else '' @endif
                                                    value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>هل للصنف سعر ثابت</label>
                                    @if (old('has_fixced_price') == '' or $errors->has('has_fixced_price'))
                                        <b class="start_has_fixced_price" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="has_fixced_price" id="has_fixced_price">
                                        <option value="">
                                            اختر الحالة
                                        </option>
                                        <option @if (old('has_fixced_price') == '1') selected  @else  '' @endif
                                            value="1">
                                            نعم ثابت ولا يتغير بالفواتير
                                        </option>
                                        <option @if (old('has_fixced_price') == '0' and (old('has_fixced_price') == '0') != '') selected  @else '' @endif
                                            value="0">
                                            لا قابل للغير بالفواتير
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>حالة التفعيل</label>
                                    @if (old('active') == '' or $errors->has('active'))
                                        <b class="start_active" style="color: rgb(240, 43, 17);">*</b>
                                    @endif
                                    <select class="custom-select" name="active" id="active">
                                        <option value="">
                                            اختر الحالة
                                        </option>
                                        <option @if (old('active') == '1') selected  @else  '' @endif
                                            value="1">
                                            مفعل
                                        </option>
                                        <option @if (old('active') == '0' and (old('active') == '0') != '') selected  @else '' @endif
                                            value="0">
                                            غير مفعل
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12" style="border: solid 1px #9290e7;margin: 10px;background: #f0f0f3;">
                                <div class="form-group">
                                    <img src="{{ asset('assets/admin/uploads/item_cards_imgs/default.png') }}"
                                        style="width: 100px" class="img-thumbnail image-preview" alt="">
                                </div>
                                <div class="form-group">
                                    <label>صورة الصنف</label>
                                    <input type="file" name="photo" class="form-control image">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card_title_center">
                    <button id="do_add_item_card" type="submit" class="btn btn-success">اضافة</button>
                    <a href="{{ route('item_cards.index') }}" type="button" class="btn btn-danger">الغاء</a>
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
    <script>
        var name = $("#uom_id option:selected").text();
        if (name != '') {
            $('.parent_uom_name').text(name);
        }
        var name = $("#retail_uom_id option:selected").text();
        if (name != '') {
            $('.child_uom_name').text(name);
        }
    </script>
    <script src="{{ URL::asset('assets/admin/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/item_card.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/image_preview.js') }}"></script>
@endsection
