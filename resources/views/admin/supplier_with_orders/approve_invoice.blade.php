<div class="col-12">
    <div class="card">
        <div class="card-header card_header_style">
            <h3 class="card-title card_title_center">تفاصيل فاتورة المشتريات</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body card_body_style">
            @if (isset($data) && !empty($data))
            @if($data->is_approved == 0)
            <form role="form" action="{{ route('supplier_orders.approved') }}" method="POST">
                @csrf
            <input type="hidden" name="id" value="{{ $data->id }}" >
            <table id="example1" class="table">
                    <tr>
                    <td>
                            <div class="form-group">
                                <label>اجمالي الاصناف بالفاتورة</label>
                                <input type="text" name="total_cost_items" id="total_cost_items" value="{{ $data->total_cost_items*1 }}" class="form-control"
                                    readonly>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>نسبة ضريبة القيمة المضافة</label>
                                <input type="text" name="tax_percent" id="tax_percent" value="{{ $data->tax_percent*1 }}" class="form-control"
                                    placeholder="">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>قيمة الضريبة المضافة</label>
                                <input type="text" name="tax_value" id="tax_value" value="{{ $data->tax_value*1 }}" class="form-control"
                                    readonly>
                            </div>
                        </td>
                                                <td>
                            <div class="form-group">
                                <label>قيمة الاجمالي قبل الخصم</label>
                                <input type="text" name="total_befor_discount" id="total_befor_discount" value="{{ $data->total_befor_discount*1 }}" class="form-control"
                                    readonly>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label>نوع الخصم</label>
                                <select name="discount_type" id="discount_type" class="form-control">
                                <option value="">لا يوجد</option>
                                <option value="1" @if($data->discount_type == 1) selected @endif >نسبة مأوية</option>
                                <option value="2" @if($data->discount_type == 2) selected @endif >قيمة يدوي</option>
                                </select>
                            </div>
                        </td>
                    <td>
                            <div class="form-group">
                                <label>نسبة الخصم</label>
                                <input type="text" name="discount_percent" id="discount_percent" value="{{ $data->discount_percent*1 }}" class="form-control"
                                    readonly>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>قيمة الخصم</label>
                                <input type="text" name="discount_value" id="discount_value" value="{{ $data->discount_value*1 }}" class="form-control"
                                    readonly>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>قيمة الاجمالي بعد الخصم</label>
                                <input type="text" name="total_cost" id="total_cost" value="{{ $data->total_cost*1 }}" class="form-control"
                                    readonly>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label>خزنة الصرف</label>
                                <input type="text" name="treasury_name" id="treasury_name" value="{{$admin_shift->treasury->name}}" class="form-control"
                                    readonly>
                                <input type="hidden" name="treasury_id" id="treasury_id" value="{{$admin_shift->treasury->id}}">
                            </div>
                        </td>
                    <td>
                            <div class="form-group">
                                <label> الرصيد المتاح بالخزنة</label>
                                <input type="text" name="treasury_money" id="treasury_money" value="{{$money*1}}" class="form-control"
                                    readonly>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>نوع الفاتورة</label>
                                <select name="pill_type" id="pill_type" class="form-control">
                                <option value="1" @if($data->pill_type == 1) selected @endif >كاش</option>
                                <option value="2" @if($data->pill_type == 2) selected @endif >أجل</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>المدفوع للمورد الان</label>
                                <input type="text" name="what_paid" id="what_paid" @if($data->pill_type == 2) value="0" @else value="{{ $data->total_cost*1 }}" readonly @endif class="form-control"
                                    placeholder="">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label>المتبقي للمورد </label>
                                <input type="text" name="what_remain" id="what_remain" @if($data->pill_type == 2) value="{{ $data->total_cost*1 }}" @else value="0" @endif class="form-control"
                                    readonly>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                                <button id="approve_invoice_now" class="btn btn-sm btn-success"> الاعتماد و ترحيل الان</button>
                        </td>
                    </tr>
                </table>
            </form>
            @else
            <div class="alert aleart-denger">
                    عفوا الفاتورة معتمدة من قبل
                </div>    
            @endif   
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
