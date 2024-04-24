@extends('admin.layouts.app')
@section('css')
@endsection
@section('headTitle')
    عرض صنف
@endsection
@section('pageTitle')
    عرض الصنف {{ $data->name }}
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li class="breadcrumb-item"><a href="{{ route('item_cards.index') }}">الاصناف</a></li>
        <li class="breadcrumb-item active">عرض صنف</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">بيانات الصنف</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body card_body_style">
                    @if (isset($data) && !empty($data))
                        <table id="example1" class="table table-bordered" style="background: #fff;">
                            <tr>
                                <td class="width20" style="background: #c3fab2">
                                    <b style="color: #000"> باركود الصنف </b>
                                    <br>{{ $data['barcode'] }}
                                </td>
                                <td class="width20" style="background: #c3fab2">
                                    <b style="color: #000"> اسم الصنف </b>
                                    <br>{{ $data['name'] }}
                                </td>
                                <td class="width20" style="background: #c3fab2">
                                    <b style="color: #000"> نوع الصنف </b>
                                    <br>
                                    @if ($data['item_type'] == 1)
                                        مخزني
                                    @elseif($data['item_type'] == 2)
                                        استهلاكي بتاريخ صلاحية
                                    @else
                                        عهدة
                                    @endif
                                </td class="width20">
                                <td class="width20" style="background: #c3fab2">
                                    <b style="color: #000"> فئة الصنف </b>
                                    <br>{{ $data->itemcard_category->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width20" colspan="1" style="background: #c6d4df">
                                    <b style="color: #000">وحدة القياس الاب</b>
                                </td>
                                <td class="width20" colspan="3" style="background: #c6d4df">
                                    {{ $data->uom->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width20 text-center" colspan="2" style="background: #c6d4df">
                                    <b style="color: #000">السعر القطاعي بوحدة </b>{{ $data->uom->name }}
                                    <br>{{ $data['price'] }}
                                </td>
                                <td class="width20 text-center" colspan="2" style="background: #c6d4df">
                                    <b style="color: #000">السعر نص جملة بوحدة </b>{{ $data->uom->name }}
                                    <br>{{ $data['nos_gomal_price'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width20 text-center" colspan="2" style="background: #c6d4df">
                                    <b style="color: #000">السعر الجملة بوحدة </b>{{ $data->uom->name }}
                                    <br>{{ $data['gomal_price'] }}
                                </td>
                                <td class="width20 text-center" colspan="2" style="background: #c6d4df">
                                    <b style="color: #000">السعر الشراء بوحدة </b>{{ $data->uom->name }}
                                    <br>{{ $data['cost_price'] }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width20" colspan="1">
                                    <b style="color: #000">هل للصنف وحدة تجزئة</b>
                                </td>
                                <td class="width20" colspan="3">
                                    @if ($data->does_has_retailunit == 1)
                                        نعم
                                    @else
                                        لا توجد
                                    @endif
                                </td>
                            </tr>
                            <tr @if ($data->does_has_retailunit != 1) style="display: none;" @endif>
                                <td class="width20" colspan="1" style="background: #dfebac">
                                    <b style="color: #000">وحدة القياس الجزئية</b>
                                </td>
                                <td class="width20" colspan="3" style="background: #dfebac">
                                    @if ($data->does_has_retailunit != 1)
                                        لا توجد
                                    @else
                                        {{ $data->retail_uom->name }}
                                    @endif
                                </td>
                            </tr>
                            <tr @if ($data->does_has_retailunit != 1) style="display: none;" @endif>
                                <td class="width20 text-center" colspan="2" style="background: #dfebac">
                                    <b style="color: #000">عدد وحدات التجزئة في الوحدة
                                    </b>
                                    {{ $data->uom->name }}
                                    <br>
                                    @if ($data->does_has_retailunit != 1)
                                        لا توجد
                                    @else
                                        {{ $data->retail_uom_quntToparent * 1 }}
                                    @endif
                                </td>
                                <td class="width20 text-center" colspan="2" style="background: #dfebac">
                                    <b style="color: #000">سعر القطاعي للوحدة الجزئية </b>
                                    @if ($data->does_has_retailunit != 1)
                                        لا توجد
                                    @else
                                        {{ $data->retail_uom->name }}
                                    @endif
                                    <br>
                                    @if ($data->does_has_retailunit != 1)
                                        لا توجد
                                    @else
                                        {{ $data->price_retail }}
                                    @endif
                                </td>
                            </tr>
                            <tr @if ($data->does_has_retailunit != 1) style="display: none;" @endif>
                                <td class="width20 text-center" colspan="2" style="background: #dfebac">
                                    <b style="color: #000">سعر نص جملة للوحدة الجزئية </b>
                                    @if ($data->does_has_retailunit != 1)
                                        لا توجد
                                    @else
                                        {{ $data->retail_uom->name }}
                                    @endif
                                    <br>
                                    @if ($data->does_has_retailunit != 1)
                                        لا توجد
                                    @else
                                        {{ $data->nos_gomal_price_retail }}
                                    @endif
                                </td>
                                <td class="width20 text-center" colspan="2" style="background: #dfebac">
                                    <b style="color: #000">سعر الجملة للوحدة الجزئية </b>
                                    @if ($data->does_has_retailunit != 1)
                                        لا توجد
                                    @else
                                        {{ $data->retail_uom->name }}
                                    @endif
                                    <br>
                                    @if ($data->does_has_retailunit != 1)
                                        لا توجد
                                    @else
                                        {{ $data->gomal_price_retail }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width20">
                                    <b style="color: #000">الصنف الرئسي</b>
                                </td>
                                <td class="width20">
                                    @if (empty($data->parent->name))
                                        هو رئسي
                                    @else
                                        {{ $data->parent->name }}
                                    @endif
                                </td>
                                <td class="width20">
                                    <b style="color: #000">حالة التفعيل</b>
                                </td>
                                <td class="width20">
                                    @if ($data->active == 1)
                                        مفعل
                                    @else
                                        غير مفعل
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width30" colspan="1">
                                    <b style="color: #000"> تاريخ اخر تحديث </b>
                                </td>
                                <td colspan="3">
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
                                    <b style="color: #000">صورة الصنف</b>
                                </td>
                                <td class="image" colspan="3">
                                    <img class="custom_img"
                                        src="{{ asset('assets/admin/uploads/item_cards_imgs') . '/' . $data['photo'] }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="width30" colspan="4">
                                    <a href="{{ route('item_cards.edit', $data->id) }}" class="btn btn-sm btn-info"><i
                                            class="fas fa-pencil-alt"></i> تحديث </a>
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
