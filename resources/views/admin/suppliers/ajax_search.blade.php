@if (isset($data) && $data->count() > 0)
<table class="table table-bordered table-hover">
    <thead class="custom_thead">
        <tr class="custom_thead">
            <th>اسم المورد</th>
            <th>رقم المورد</th>
            <th>رقم الحساب المالي</th>
            <th>فئة المورد</th>
            <th>الرصيد</th>
            <th>حالة التفعيل</th>
            <th>الاجراءت</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $info)
        <tr>
            <td>{{ $info->name }}</td>
            <td>{{ $info->supplier_code }}</td>
            <td>
                @if (isset($info->accuont->account_number))
                {{ $info->accuont->account_number }}
                @else
                غير موجود
                @endif
            </td>
            <td>
                @if (isset($info->supplierCategory->name))
                {{ $info->supplierCategory->name }}
                @else
                غير موجود
                @endif
            </td>
            <td>
                @if($info->current_balance > 0)
                مدين ب ({{ $info->current_balance * 1 }} جنيه )
                @elseif($info->current_balance < 0) دائن ب ({{ $info->current_balance * -1 }} جنيه ) @else متزن (0 جنيه ) @endif </td>
            <td>
                @if ($info->active == 1)
                مفعل
                @else
                معطل
                @endif
            </td>
            <td>
                <a href="{{ route('suppliers.edit', $info->id) }}" class="btn btn-sm btn-info"> <i class="fas fa-pencil-alt"></i></a>
                <!--<a href="{{ route('suppliers.show', $info->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye"></i>
                </a> -->
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-show{{ $info->id }}">
                    تفاصيل
                </button>
                <!-- <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete{{ $info->id }}">
                    <i class="fas fa-trash"></i>
                </button> -->
                <!-- show modal -->
                <div class="modal fade" id="modal-show{{ $info->id }}">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content bg-default">
                            <div class="modal-header">
                                <h4 class="modal-title">تفاصيل المورد -
                                    {{ $info->name }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <tr>
                                        <td class="table_td1">
                                            العنوان
                                        </td>
                                        <td class="table_td2">
                                            {{ $info->address }}
                                        </td>
                                        <td class="table_td1">
                                            رقم الهاتف
                                        </td>
                                        <td class="table_td2">
                                            {{ $info->phone }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table_td1">
                                            تاريخ الاضافة
                                        </td>
                                        <td class="table_td2">
                                            @php
                                            $dt = new DateTime(
                                            $info->created_at,
                                            );
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('H:i');
                                            $newDateTime = date(
                                            'A',
                                            strtotime($time),
                                            );
                                            $newDateTimeType =
                                            $newDateTime == 'AM'
                                            ? 'صباحا'
                                            : 'مساء';
                                            @endphp
                                            {{ $date }}
                                            <br>
                                            {{ $time }}
                                            {{ $newDateTimeType }}<br>
                                            بواسطة :
                                            {{ $info->added_by_admin }}
                                        </td>
                                        <td class="table_td1">
                                            تاريخ التحديث
                                        </td>
                                        <td class="table_td2">
                                            @if ($info['updated_by'] > 0 and $info['updated_by'] != null)
                                            @php
                                            $dt = new DateTime(
                                            $info['updated_at'],
                                            );
                                            $date = $dt->format('Y-m-d');
                                            $time = $dt->format('H:i');
                                            $newDateTime = date(
                                            'A',
                                            strtotime($time),
                                            );
                                            $newDateTimeType =
                                            $newDateTime == 'AM'
                                            ? 'صباحا'
                                            : 'مساء';
                                            @endphp
                                            {{ $date }}
                                            <br>
                                            {{ $time }}
                                            {{ $newDateTimeType }}<br>
                                            بواسطة :
                                            {{ $info->updated_by_admin }}
                                            @else
                                            لا يوجد تحديث
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table_td1">
                                            ملاحظات
                                        </td>
                                        <td colspan="3" class="table_td2">
                                            {{ $info->notes }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table_td1">
                                            الصورة
                                        </td>
                                        <td colspan="3">
                                            <div class="col-sm-12" style="margin: 5px;">
                                                <div class="form-group">
                                                    <img src="{{ asset('assets/admin/uploads/suppliers_imgs/'.$info->photo) }}" style="width: 100px" class="img-thumbnail image-preview" alt="">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">الغاء</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- end show modal -->
                <!-- are you shue modal -->
                <div class="modal fade" id="modal-delete{{ $info->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content bg-danger">
                            <div class="modal-header">
                                <h4 class="modal-title">تحذير</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    هل انت متاكد من عملية الحذف المورد
                                    <b>{{ $info->name }} </b>؟
                                </p>
                                <p>
                                    سوف يتم حذف حسابه المالي ايضا
                                </p>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <form action="{{ route('suppliers.destroy', $info->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-outline-light">متابعة</button>
                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">الغاء</button>
                                </form>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- end are you shue modal -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
<div class="col-md-12" id="ajax_pagination_in_search">
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