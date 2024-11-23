<div class="col-12">
            <div class="card">
                <div class="card-header card_header_style">
                    <h3 class="card-title card_title_center">تفاصيل فاتورة المشتريات</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body card_body_style">
                    @if (isset($data) && $data->count() > 0)
                        <table id="example1" class="table table-bordered table-striped">
                            <tr>
                                <td class="width20">
                                    <b style="color: #000">كود الفاتورة الألي</b>
                                </td>
                                <td>
                                    {{ $data->auto_serial }}
                                </td>
                                <td class="width20">
                                    <b style="color: #000">كود الفاتورة بأصل فاتورة المورد</b>
                                </td>
                                <td>
                                    {{ $data->doc_no }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width20">
                                    <b style="color: #000">تاريخ الفاتورة</b>
                                </td>
                                <td>{{ $data->order_date }}</td>
                                <td class="width20">
                                    <b style="color: #000">اسم المورد</b>
                                </td>
                                <td>
                                    @if (isset($data->supplier->name))
                                        {{ $data->supplier->name }}
                                    @else
                                        غير موجود ربما تم حذفه
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width20">
                                    <b style="color: #000">المخزن</b>
                                </td>
                                <td>
                                    @if (isset($data->store->name))
                                        {{ $data->store->name }}
                                    @else
                                        غير موجود ربما تم حذفه
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    <b style="color: #000">نوع الفاتورة</b>
                                </td>
                                <td>
                                    @if ($data->pill_type == 1)
                                        كاش
                                    @else
                                        أجل
                                    @endif
                                </td>
                                <td class="width30">
                                    <b style="color: #000">اجمالي قيمة الفاتورة</b>
                                </td>
                                <td>
                                    {{ $data->total_befor_discount }}
                                </td>
                            </tr>
                            @if ($data->discount_type)
                                <tr>
                                    <td class="width30">
                                        الخصم على الفاتورة
                                    </td>
                                    <td>
                                        @if ($data->discount_type == 1)
                                            خصم بنسبة ({{ $data->discount_percent * 1 }}) و قيمتها
                                            ({{ $data->discount_value * 1 }})
                                        @else
                                            خصم يدوي و قيمته ({{ $data->discount_value * 1 }})
                                        @endif
                                    </td>
                                @else
                                    <td class="width30">
                                        الخصم على الفاتورة
                                    </td>
                                    <td>
                                        لا يوجد
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="width30">
                                    نسبة القيمة المضافة
                                </td>
                                <td>
                                    @if ($data->tax_percent <= 0)
                                        لا يوجد
                                    @else
                                        بنسبة ({{ $data->tax_percent * 1 }}) % و قيمتها ({{ $data->tax_value * 1 }})
                                    @endif
                                </td>
                                <td class="width30">
                                    تاريخ الأضافة
                                </td>
                                <td>
                                    @php
                                        $dt = new DateTime($data['created_at']);
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
                                    {{ $data->added_by_admin }}
                                </td>
                            </tr>
                            <tr>
                                <td class="width30">
                                    تاريخ اخر تحديث
                                </td>
                                <td>
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
                                        {{ $data->updated_by_admin }}
                                    @else
                                        لا يوجد تحديث
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if ($data->is_approved == 0)
                                        <button data-toggle="modal" data-target="#ModelApproveInvoice" id="do_close_approve_invoice" class="btn btn-sm btn-success">تحميل الاعتماد و الترحيل</button>
                                        <a href="{{ route('supplier_orders.edit', $data->id) }}"
                                            class="btn btn-sm btn-info"> <i class="fas fa-pencil-alt"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modal-delete{{ $data->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div class="card-header card_header_style">
                            @if ($data->is_approved == 0)
                                <h3 class="card-title card_title_center">اصناف الفاتورة
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#Add_item_cards">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </h3>
                            @endif
                        </div>
                        <div class="card-body table-responsive p-2 card_body_style">
                            <div id="loade_item">
                                @if (isset($supplier_with_order_details) && $supplier_with_order_details->count() > 0)
                                    @php
                                        $i = 1;
                                    @endphp
                                    <table class="table table-bordered table-hover">
                                        <thead class="custom_thead">
                                            <tr class="custom_thead">
                                                <th>#</th>
                                                <th> الصنف</th>
                                                <th>الوحدة</th>
                                                <th>الكمية</th>
                                                <th>السعر</th>
                                                <th>الاجمالي</th>
                                                @if ($data->is_approved == 0)
                                                    <th>الاجراءت</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($supplier_with_order_details as $info)
                                                <tr id="item_card-{{ $info->id }}" style="display:show;">
                                                    <td>{{ $i }}</td>
                                                    <td>
                                                        @if (isset($info->item_cards->name))
                                                            {{ $info->item_cards->name }}<br>
                                                            @if ($info->item_type == 2)
                                                                pro - {{ $info->pro_date }}<br>
                                                                ex -{{ $info->ex_date }}
                                                            @endif
                                                        @else
                                                            <b style="color:red;">
                                                                تم حذفه من النظام
                                                            </b>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($info->is_master_uom == 0)
                                                            @if (isset($info->item_cards->retail_uom->name))
                                                                {{ $info->item_cards->retail_uom->name }}
                                                            @else
                                                                <b style="color:red;">
                                                                    تم حذفه من النظام
                                                                </b>
                                                            @endif
                                                        @else
                                                            @if (isset($info->item_cards->uom->name))
                                                                {{ $info->item_cards->uom->name }}
                                                            @else
                                                                <b style="color:red;">
                                                                    تم حذفه من النظام
                                                                </b>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{ $info->deliverd_quantity * 1 }}</td>
                                                    <td>{{ $info->unit_price * 1 }}</td>
                                                    <td>{{ $info->total_price * 1 }}</td>
                                                    @if ($data->is_approved == 0)
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modal-delete{{ $info->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            <!-- are you shue modal -->
                                                            <div class="modal fade" id="modal-delete{{ $info->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content bg-danger">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">تحذير</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>هل انت متاكد من عملية الحذف ؟</p>
                                                                        </div>
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button id="delete_item_card" type="button"
                                                                                value="{{ $info->id }}"
                                                                                data-dismiss="modal"
                                                                                class="btn btn-outline-light">متابعة
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-outline-light"
                                                                                data-dismiss="modal">الغاء</button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- end are you shue modal -->
                                                        </td>
                                                    @endif
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="card_title_center">
                                        <p class="btn btn-danger btn-sm">
                                            لاتوجد اصناف حاليا
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
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
