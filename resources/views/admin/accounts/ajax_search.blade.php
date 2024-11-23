@if (isset($data) && $data->count() > 0)
<table class="table table-bordered table-hover">
    <thead class="custom_thead">
        <tr class="custom_thead">
            <th>اسم الحساب</th>
            <th>رقم الحساب</th>
            <th>نوع الحساب</th>
            <th>هل رئيسي</th>
            <th>الرصيد</th>
            <th>حالة الأرشفة</th>
            <th>الاجراءت</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $info)
        <tr>
            <td>{{ $info->name }}</td>
            <td>{{ $info->account_number }}</td>
            <td>{{ $info->account_type->name }}</td>
            <td>
                @if ($info->account_id == 0)
                رئيسي
                @else
                فرعي و الرئيسي له
                <br>
                @if (isset($info->parent->name))
                <small> {{ $info->parent->name }}</small>
                @else
                <small>غير موجود ربما تم حذفه</small>
                @endif
                @endif
            </td>
            <td>
                @if($info->is_parent == 1)
                @if($info->current_balance > 0)
                مدين ب ({{ $info->current_balance * 1 }} جنيه )
                @elseif($info->current_balance < 0) دائن ب ({{ $info->current_balance * -1 }} جنيه ) @else متزن (0 جنيه ) @endif @else من ميزان المراجعة @endif </td>
            <td>
                @if ($info->is_archived == 1)
                مؤرشف
                @else
                غير مؤرشف
                @endif
            </td>
            <td>
                @if ($info->account_type->relatedIternalAccounts == 0)
                <a href="{{ route('accounts.edit', $info->id) }}" class="btn btn-sm btn-info"><i class="fas fa-pencil-alt"></i></a>
                @else
                <button href="{{ route('accounts.edit', $info->id) }}" class="btn btn-sm btn-info" onmousemove="style='background-color:red'" @disabled(true)> <i class="fas fa-pencil-alt"></i></button>
                @endif
                <!-- <a href="{{ route('accounts.show', $info->id) }}" class="btn btn-primary btn-sm">
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
                    <div class="modal-dialog">
                        <div class="modal-content bg-default">
                            <div class="modal-header">
                                <h4 class="modal-title">تفاصيل حساب -
                                    {{ $info->name }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table id="example1" class="table table-bordered table-striped">
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
                                    هل انت متاكد من عملية الحذف الحساب
                                    <b>{{ $info->name }} </b>؟
                                </p>
                                <p>
                                    اذا كان رئسي ربما تنتمي اليه حسابات اخره
                                </p>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <form action="{{ route('accounts.destroy', $info->id) }}" method="POST">
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
