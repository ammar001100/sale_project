@if (isset($data) && $data->count() > 0)
<table class="table table-bordered table-hover">
    <thead class="custom_thead">
        <tr class="custom_thead">
            <th>كود الفاتورة</th>
            <th>العميل</th>
            <th>نوع الفاتورة</th>
            <th>فئة الفاتورة</th>
            <th>اجمالي الفاتورة</th>
            <th>تاريخ الفاتورة</th>
            <th>الاجراءت</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $info)
        @php
        //$random_color = sprintf("#%06X",mt_rand(0,0xFFFFFF));
        $random_color= "#000000";
        @endphp
        <tr>
            <td><b style="color: {{ $random_color }};
             font-size:20px;
              font-weight:bold;
              font-family:Arial,sans-serif;
              text-shadow:3px 3px 8px rgba(0,0,0,0.5)
              transition:color 0.5s ease;
              cursor:pointer;
              " onmouseover="this.style.color='#ff5733'" onmouseout="this.style.color='{{ $random_color }}'">{{ $info->auto_serial }}</b></td>
            <td>
                @if (isset($info->customer->name))
                <b style="color: {{ $random_color }}">{{ $info->customer->name }}</b>
                @else
                <b style="color: rgb(213, 88, 88)">بدون عميل</b>
                @endif
            </td>
            <td>
                @if ($info->pill_type == 1)
                <b style="color: {{ $random_color }}">كاش</b>
                @elseif($info->pill_type == 2)
                <b style="color: {{ $random_color }}">أجل</b>
                @else
                <b style="color: {{ $random_color }}">غير محدد</b>
                @endif
            </td>
            <td>
                @if ($info->sales_matrial_type)
                <b style="color: {{ $random_color }}">{{ $info->sales_matrial_type->name }}</b>
                @else
                <b style="color: red">لا توجد فئة ربما تم حذفها</b>
                @endif
            </td>
            <td>
                <b style="color: {{ $random_color }}">{{ $info->sale_inv_details->sum('total_price' ) }}</b>
            </td>
            <td>
                <b style="color: {{ $random_color }}">{{ $info->invoice_date }}</b>
            </td>
            <td>
                <a href="{{ route('sale_invoices.show', $info->id) }}" class="btn btn-primary btn-sm">
                    التفاصيل
                </a>
                @if ($info->is_approved == 0)
                <!-- <a href="{{ route('sale_invoices.edit', $info->id) }}" class="btn btn-sm btn-info"> 
                        <i class="fas fa-pencil-alt"></i>
                     </a>  -->
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete{{ $info->id }}">
                    <i class="fas fa-trash"></i>
                </button>
                @endif
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
                                <form action="{{ route('sale_invoices.destroy', $info->id) }}" method="POST">
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
