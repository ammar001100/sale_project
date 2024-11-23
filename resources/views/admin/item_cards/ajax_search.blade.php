@if (isset($data) && $data->count() > 0)
    @php
        $i = 1;
    @endphp
    <table class="table table-bordered table-hover">
        <thead class="custom_thead">
            <tr class="custom_thead">
                <th>#</th>
                <th>اسم الصنف</th>
                <th>نوع الصنف</th>
                <th>فئة الصنف</th>
                <th>الصنف الاب</th>
                <th>الوحدة الاب</th>
                <th>الوحدة التجزئة</th>
                <th>الاجراءت</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $info)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $info->name }}</td>
                    <td>
                        @if ($info->item_type == 1)
                            مخزني
                        @elseif($info->item_type == 2)
                            استهلاكي بصلاحية
                        @elseif($info->item_type == 3)
                            عهدة
                        @else
                            غير محدد
                        @endif
                    </td>
                    <td>{{ $info->itemcard_category->name }}</td>
                    <td>
                        @if ($info->item_card_id != 0)
                            {{ $info->parent->name }}
                        @else
                            صنف اب
                        @endif
                    </td>
                    <td>{{ $info->uom->name }}</td>
                    <td>
                        @if (empty($info->retail_uom->name))
                            لا توجد
                        @else
                            {{ $info->retail_uom->name }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('item_cards.edit', $info->id) }}" class="btn btn-sm btn-info"> <i
                                class="fas fa-pencil-alt"></i></a>
                        <!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                                                                        data-target="#modal-show{{ $info->id }}">
                                                                                                        <i class="fas fa-eye"></i>-->
                        </button>
                        <a href="{{ route('item_cards.show', $info->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#modal-delete{{ $info->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <!-- show modal -->
                        <div class="modal fade" id="modal-show{{ $info->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content bg-default">
                                    <div class="modal-header">
                                        <h4 class="modal-title">تفاصيل مخزن -
                                            {{ $info->name }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <tr>
                                                <td class="width30">
                                                    حالة التفعيل
                                                </td>
                                                <td>
                                                    @if ($info->active == 1)
                                                        مفعل
                                                    @else
                                                        غير مفعل
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width30">
                                                    تاريخ الاضافة
                                                </td>
                                                <td>
                                                    @php
                                                        $dt = new DateTime($info->created_at);
                                                        $date = $dt->format('Y-m-d');
                                                        $time = $dt->format('H:i');
                                                        $newDateTime = date('A', strtotime($time));
                                                        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساء';
                                                    @endphp
                                                    {{ $date }}
                                                    <br>
                                                    {{ $time }}
                                                    {{ $newDateTimeType }}<br>
                                                    بواسطة :
                                                    {{ $info->added_by_admin }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="width30">
                                                    تاريخ التحديث
                                                </td>
                                                <td>
                                                    @if ($info['updated_by'] > 0 and $info['updated_by'] != null)
                                                        @php
                                                            $dt = new DateTime($info['updated_at']);
                                                            $date = $dt->format('Y-m-d');
                                                            $time = $dt->format('H:i');
                                                            $newDateTime = date('A', strtotime($time));
                                                            $newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساء';
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

                                        </table>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">الغاء</button>
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
                                        <p>هل انت متاكد من عملية الحذف ؟</p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <a href="{{ route('item_cards.destroy', $info->id) }}" type="button"
                                            class="btn btn-outline-light">متابعة</a>
                                        <button type="button" class="btn btn-outline-light"
                                            data-dismiss="modal">الغاء</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- end are you shue modal -->
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
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
