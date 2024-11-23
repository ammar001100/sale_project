@if (isset($data) && $data->count() > 0)
<table class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <tr class="custom_thead">
                                        <th>كود الفاتورة</th>
                                        <th>المورد</th>
                                        <th>نوع الفاتورة</th>
                                        <th>حالة الفاتورة</th>
                                        <th>سعر الفاتورة</th>
                                        <th>تاريخ الفاتورة</th>
                                        <th>الاجراءت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $info->auto_serial }}</td>
                                            <td>
                                                @if (isset($info->supplier->name))
                                                    {{ $info->supplier->name }}
                                                @else
                                                    غير موجود
                                                @endif
                                            </td>
                                            <td>
                                                @if ($info->pill_type == 1)
                                                    كاش
                                                @elseif($info->pill_type == 2)
                                                    أجل
                                                @else
                                                    غير محدد
                                                @endif
                                            </td>
                                            <td>
                                                @if ($info->is_approved == 1)
                                                    <b style="color: green">معتمدة</b>
                                                @else
                                                    <b style="color: red">مفتوحة</b>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $info->total_cost * 1 }}
                                            </td>
                                            <td>
                                                {{ $info->order_date }}
                                            </td>
                                            <td>
                                                <a href="{{ route('supplier_orders.show', $info->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    التفاصيل
                                                </a>
                                                @if ($info->is_approved == 0)
                                                    <a href="{{ route('supplier_orders.edit', $info->id) }}"
                                                        class="btn btn-sm btn-info"> <i class="fas fa-pencil-alt"></i></a>                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#modal-delete{{ $info->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                                <!-- are you shue modal -->
                                                <div class="modal fade" id="modal-delete{{ $info->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content bg-danger">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">تحذير</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>هل انت متاكد من عملية الحذف ؟</p>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <form
                                                                    action="{{ route('supplier_orders.destroy', $info->id) }}"
                                                                    method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-outline-light">متابعة</button>
                                                                    <button type="button" class="btn btn-outline-light"
                                                                        data-dismiss="modal">الغاء</button>
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