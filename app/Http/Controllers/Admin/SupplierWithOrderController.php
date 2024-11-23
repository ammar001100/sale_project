<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuplierWithOrderApproveBursahseRequest;
use App\Http\Requests\SupplierWithOrderRequest;
use App\Models\Account;
use App\Models\Itemcard_batche;
use App\Models\Itemcard_movement;
use App\Models\Item_card;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Supplier_with_order;
use App\Models\Supplier_with_order_details;
use App\Models\Treasury;
use App\Models\Treasury_transaction;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class SupplierWithOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use GeneralTrait;

    public function index()
    {
        try {
            $data = Supplier_with_order::selection()->with('supplier', 'store')->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);
            $supplier = Supplier::SelectionActive()->get();
            $stores = Store::SelectionActive()->get();

            return view('admin.supplier_with_orders.index', compact('data', 'supplier', 'stores'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $supplier = Supplier::SelectionActive()->get();
            $stores = Store::SelectionActive()->get();

            return view('admin.supplier_with_orders.create', compact('supplier', 'stores'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierWithOrderRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //set auto serial
            $row = Supplier_with_order::Selection()->first();
            if (!$row) {
                $data_insert['auto_serial'] = 1;
            } else {
                $data_insert['auto_serial'] = $row->auto_serial + 1;
            }
            //get account number
            $supplier = Supplier::Selection()->where('id', $request->supplier_id)->first();
            if (!$supplier) {
                session()->flash('error', 'عفوا النظام غير قادر على الوصول لبيانات المورد');

                return redirect()->back()->withInput();
            }
            $data_insert['order_date'] = $request->order_date;
            $data_insert['order_type'] = 1;
            $data_insert['supplier_id'] = $request->supplier_id;
            $data_insert['store_id'] = $request->store_id;
            $data_insert['pill_type'] = $request->pill_type;
            $data_insert['active'] = $request->active;
            $data_insert['doc_no'] = $request->doc_no;
            $data_insert['notes'] = $request->notes;
            $data_insert['account_number'] = $supplier->account_number;
            $data_insert['active'] = $request->active;
            $data_insert['com_code'] = $com_code;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['date'] = date('Y-m-d');
            Supplier_with_order::create($data_insert);
            session()->flash('success', 'تم اضافة فاتورة المشتريات بنجاح');

            return redirect()->route('supplier_orders.index');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Supplier_with_order::selection()->with('supplier_with_order_details', 'supplier', 'store')->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا فاتورة المشتريات غير موجودة');

                return redirect()->route('supplier_orders.index');
            }
            $data = $this->added_byAndUpdated_by($data);

            $supplier_with_order_details = $data->supplier_with_order_details()->with('item_cards')->get();
            //$item_card = $data->supplier_with_order_details()->with('item_card')->get();
            if ($data->is_approved == 0) {
                $item_card = Item_card::active()->get();
            } else {
                $item_card = [];
            }
            //return $data->supplier_with_order_details()->with('item_card')->get();

            return view('admin.supplier_with_orders.show', compact('data', 'item_card', 'supplier_with_order_details'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function ajax_get_uom(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Item_card::selection()->with(['retail_uom', 'uom'])->find($request->item_card_id);

                return view('admin.supplier_with_orders.ajax_get_uom', compact('data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function ajax_add_uom(Request $request)
    {
        try {
            if ($request->ajax()) {
                $supplier_with_order = Supplier_with_order::selection()->with('supplier_with_order_details', 'supplier', 'store')->find($request->supplier_with_order_id);
                if ($supplier_with_order->is_approved == 0) {
                    $data_insert['supplier_with_order_id'] = $request->supplier_with_order_id;
                    $data_insert['item_card_id'] = $request->item_card_id;
                    $data_insert['item_type'] = $request->item_type;
                    $data_insert['order_type'] = 1;
                    $data_insert['deliverd_quantity'] = $request->quantity;
                    $data_insert['unit_price'] = $request->price;
                    $data_insert['uom_id'] = $request->uom_id;
                    $data_insert['is_master_uom'] = $request->is_parent_uom;
                    $data_insert['total_price'] = $request->total;
                    if ($request->item_type == 2) {
                        $data_insert['pro_date'] = $request->pro_date;
                        $data_insert['ex_date'] = $request->ex_date;
                    }
                    $data_insert['order_date'] = $supplier_with_order->order_date;
                    $data_insert['com_code'] = auth()->user()->com_code;
                    $data_insert['added_by'] = auth()->user()->id;
                } else {
                    return response()->json([
                        'status' => false,
                        'msg' => 'لا يمكن العمل على فاتورة معتمدة',
                    ]);
                }

                $flag = Supplier_with_order_details::create($data_insert);
                if ($flag) {
                    $total_sum = Supplier_with_order_details::where('supplier_with_order_id', $request->supplier_with_order_id)->sum('total_price');
                    $order = $supplier_with_order;
                    $order->total_cost_items = $total_sum;
                    $order->total_befor_discount = $total_sum + $supplier_with_order->tax_value;
                    $order->total_cost = $order->total_befor_discount - $supplier_with_order->discount_value;
                    $order->updated_by = auth()->user()->id;
                    $order->save();
                    $data = $order;
                    if ($data->is_approved == 0) {
                        $item_card = Item_card::active()->get();
                    } else {
                        $item_card = [];
                    }
                    $supplier_with_order_details = $order->supplier_with_order_details()->with('item_cards')->get();

                    return view('admin.supplier_with_orders.ajax_loade_page', compact('supplier_with_order_details', 'data', 'item_card'));
                } else {
                    return 'يوجد خطاء في الاضافة';
                }
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function ajax_delete_item_card(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Supplier_with_order::selection()->with('supplier_with_order_details', 'supplier', 'store')->find($request->supplier_with_order_id);
                if (empty($data)) {
                    return $msg = 'عفوا الفاتورة غير موجودة ';
                }
                if ($data->is_approved == 1) {
                    return response()->json([
                        'status' => false,
                        'msg' => 'لا يمكن حذف تفاصيل فاتورة معتمدة',
                    ]);
                }
                //delete item
                $data_item_de = Supplier_with_order_details::selection()->find($request->id);
                if (empty($data_item_de)) {
                    return $msg = 'عفوا الصنف غير موجود في الفاتورة';
                }
                $data_item_de->delete();
                //update supplier with_order details
                $supplier_with_order_details = $data->supplier_with_order_details()->with('item_cards')->get();
                $total_sum = Supplier_with_order_details::where('supplier_with_order_id', $request->supplier_with_order_id)->sum('total_price');
                $order = $data;
                $order->total_cost_items = $total_sum;
                $order->total_befor_discount = $total_sum + $data->tax_value;
                $order->total_cost = $order->total_befor_discount - $order->discount_value;
                $order->updated_by = auth()->user()->id;
                $order->save();
                $data = $order;

                //return $data;
                if ($data->is_approved == 0) {
                    $item_card = Item_card::active()->get();
                } else {
                    $item_card = [];
                }
                $supplier_with_order_details = $data->supplier_with_order_details()->with('item_cards')->get();

                return view('admin.supplier_with_orders.ajax_loade_page', compact('supplier_with_order_details', 'data', 'item_card'));
            }
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = Supplier_with_order::selection()->find($id);
            $supplier = Supplier::SelectionActive()->get();
            $stores = Store::SelectionActive()->get();
            if ($data == null) {
                session()->flash('error', 'عفوا فاتورة المشتريات غير موجوده');

                return redirect()->back();
            } else {
                return view('admin.supplier_with_orders.edit', compact('data', 'supplier', 'stores'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierWithOrderRequest $request, string $id)
    {
        try {
            $data = Supplier_with_order::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا فاتورة المشتريات غير موجودة');

                return redirect()->back();
            }
            if ($data->is_approved == 1) {
                session()->flash('error', 'عفوا لا يمكن تعديل تفاصيل فاتورة معتمدة');

                return redirect()->route('supplier_orders.index');
            }
            $com_code = auth()->user()->com_code;
            //get account number
            $supplier = Supplier::Selection()->where('id', $request->supplier_id)->first();
            if (!$supplier) {
                session()->flash('error', 'عفوا النظام غير قادر على الوصول لبيانات المورد');

                return redirect()->back()->withInput();
            }
            $data_insert_update['order_date'] = $request->order_date;
            $data_insert_update['order_type'] = 1;
            $data_insert_update['supplier_id'] = $request->supplier_id;
            $data_insert_update['store_id'] = $request->store_id;
            $data_insert_update['pill_type'] = $request->pill_type;
            $data_insert_update['active'] = $request->active;
            $data_insert_update['doc_no'] = $request->doc_no;
            $data_insert_update['notes'] = $request->notes;
            $data_insert_update['account_number'] = $supplier->account_number;
            $data_insert_update['active'] = $request->active;
            $data_insert_update['com_code'] = $com_code;
            $data_insert_update['updated_by'] = auth()->user()->id;
            $data_insert_update['date'] = date('Y-m-d');
            Supplier_with_order::selection()->where('id', $id)->update($data_insert_update);
            session()->flash('success', 'تم تحديث فاتورة المشتريات بنجاح');

            return redirect()->route('supplier_orders.show', $id);
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Supplier_with_order::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا فاتورة الشراء غير موجودة');

                return redirect()->back()->withInput();
            }
            if ($data->is_approved == 1) {
                session()->flash('error', 'عفوا لا يمكن حذف تفاصيل فاتورة معتمدة');

                return redirect()->route('supplier_orders.index');
            }
            $supplier_with_order_details = $data->supplier_with_order_details()->delete();
            $data->delete();
            session()->flash('success', 'تم حذف بيانات فاتورة الشراء بنجاح');

            return redirect()->route('supplier_orders.index');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }
    public function approve_invoice(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Supplier_with_order::Selection()->with('supplier', 'store')->find($request->id);
                $data = $this->added_byAndUpdated_by($data);
                //check if admin has open shift or not
                $admin_shift = $this->get_user_shift();
                if (empty($admin_shift)) {
                    session()->flash('error', 'عفوا لا يوجد لديك شفت مفتوح حاليا');

                    return redirect()->back();
                }
                $money = $this->get_current_balance();
                if ($money == false) {
                    session()->flash('error', 'عفوا بيانات الشفت او الخزنة غير موجودة');
                    return redirect()->back();
                }
                return view('admin.supplier_with_orders.approve_invoice', compact('data', 'admin_shift', 'money'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }
    public function approve_invoice_now(Request $request)
    {
        try {
            if ($request->ajax()) {
                $admin_shift = $this->get_user_shift();
                if (empty($admin_shift)) {
                    session()->flash('error', 'عفوا لا يوجد لديك شفت مفتوح حاليا');

                    return redirect()->back();
                }
                $money = $this->get_current_balance();
                if ($money == false) {
                    session()->flash('error', 'عفوا بيانات الشفت او الخزنة غير موجودة');
                    return response(false);
                }
                return response($money);
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }
    public function do_approved(SuplierWithOrderApproveBursahseRequest $request)
    {
        try {
            $data = Supplier_with_order::Selection()->with('supplier', 'store', 'supplier_with_order_details')->find($request->id);
            $supplier_name = $data->supplier->name;
            $money = $this->get_current_balance();
            if ($money == false) {
                session()->flash('error', 'عفوا بيانات الشفت او الخزنة غير موجودة');
                return redirect()->back();
            }
            if (empty($data)) {
                session()->flash('error', 'عفوا بيانات الفاتورة غير موجودة');
                return redirect()->back();
            }
            if ($request->total_cost_items == 0) {
                session()->flash('error', 'من فضلك يجب اضافة اصناف الى الفاتورة');
                return redirect()->back();
            }
            //check is approved
            if ($data->is_approved == 1) {
                session()->flash('error', 'عفوا هذه الفاتورة معتمدة من قبل');
                return redirect()->back();
            }
            $dataUpdateParent['is_approved'] = 1;
            $dataUpdateParent['tax_percent'] = $request->tax_percent;
            $dataUpdateParent['tax_value'] = $request->tax_value;
            $dataUpdateParent['total_befor_discount'] = $request->total_befor_discount;
            $dataUpdateParent['discount_type'] = $request->discount_type;
            $dataUpdateParent['discount_percent'] = $request->discount_percent;
            $dataUpdateParent['discount_value'] = $request->discount_value;
            $dataUpdateParent['total_cost'] = $request->total_cost;
            $dataUpdateParent['pill_type'] = $request->pill_type;
            $dataUpdateParent['money_for_account'] = $request->total_cost * -1;
            $dataUpdateParent['added_by'] = auth()->user()->id;
            //first check for pill type state cash
            if ($request->pill_type == 1) {
                if ($request->what_paid != $request->total_cost) {
                    session()->flash('error', 'عفوا يجب ان يكون المبلغ مدفوع كاملا في حالة نوع تافاتورة كاش');
                    return redirect()->back();
                }
                if ($request->what_paid > $money) {
                    session()->flash('error', 'عفوا المبلغ المدفوع اكبر من المبلغ الموجود بالخزنة');
                    return redirect()->back();
                }
                if ($request->what_paid > $request->total_cost) {
                    session()->flash('error', 'عفوا المبلغ المدفوع اكبر من اجمالي الفاتورة');
                    return redirect()->back();
                }
                $dataUpdateParent['what_paid'] = $request->what_paid;
            }
            //second check for pill type state agel
            if ($request->pill_type == 2) {
                if ($request->what_paid == $request->total_cost) {
                    session()->flash('error', 'عفوا يجب ان يكون المبلغ المدفوع غير كاملا في حالة نوع تافاتورة أجل');
                    return redirect()->back();
                }
                if ($request->what_paid > $money) {
                    session()->flash('error', 'عفوا المبلغ المدفوع اكبر من المبلغ الموجود بالخزنة');
                    return redirect()->back();
                }
                if ($request->what_paid > $request->total_cost) {
                    session()->flash('error', 'عفوا المبلغ المدفوع اكبر من اجمالي الفاتورة');
                    return redirect()->back();
                }
                $dataUpdateParent['what_paid'] = $request->what_paid;
                $dataUpdateParent['what_remain'] = $request->what_remain;
            }
            $flag = Supplier_with_order::where('id', $request->id)->update($dataUpdateParent);
            if ($flag) {
                //حركات مختلفة
                //first make treasuries_transaction if whatn_paid > 0
                if ($request->what_paid > 0) {
                    $admin_shift = $this->get_user_shift();
                    //get auto last isal collect with treasury
                    $treasury = Treasury::selection()->where('id', $request->treasury_id)->select('last_isal_exhcange')->orderby('id', 'DESC')->first();
                    if (empty($treasury)) {
                        session()->flash('error', 'عفوا بيانات الخزنة غير موجودة');

                        return redirect()->back();
                    }
                    //set auto serial
                    $row = Treasury_transaction::Selection()->orderby('id', 'DESC')->first();

                    if (!$row) {
                        $data_insert_transaction['auto_serial'] = 1;
                    } else {
                        $data_insert_transaction['auto_serial'] = $row->auto_serial + 1;
                    }
                    //set trans code
                    $random = random_int(10000, 99999);
                    $random = substr($random, 0, 5);

                    $data_insert_transaction['isal_number'] = $treasury->last_isal_exhcange + 1;
                    $data_insert_transaction['trans_code'] = $data_insert_transaction['isal_number'] . $random;
                    $data_insert_transaction['treasury_id'] = $request->treasury_id;
                    $data_insert_transaction['admin_shift_id'] = $admin_shift->id;
                    $data_insert_transaction['mov_type_id'] = 3;
                    $data_insert_transaction['account_id'] = $data->account_number;
                    $data_insert_transaction['money'] = $request->what_paid * (-1); //مدين
                    $data_insert_transaction['mov_date'] = date('Y-m-d');
                    $data_insert_transaction['is_approved'] = 1;
                    $data_insert_transaction['is_account'] = 1;
                    $data_insert_transaction['approved_by'] = auth()->user()->id;
                    $data_insert_transaction['money_for_account'] = $request->what_paid; //دائن
                    $data_insert_transaction['byan'] = 'صرف نظير مشتريات من مورد' . '(' . ($supplier_name) . ')' . ' فاتورة رقم ' . '(' . ($data->auto_serial) . ')';
                    $data_insert_transaction['added_by'] = auth()->user()->id;
                    $data_insert_transaction['date'] = date('Y-m-d');
                    $data_insert_transaction['com_code'] = auth()->user()->com_code;
                    $data_insert_transaction['the_foregin_key'] = $data->id;
                    $flag_transaction = Treasury_transaction::create($data_insert_transaction);
                    if ($flag_transaction) {
                        Treasury::selection()->where('id', $request->treasury_id)
                            ->update(['last_isal_exhcange' => $data_insert_transaction['isal_number']]);
                    }
                }
                //التأثير في حساب المورد
                $this->refresh_account_blance(
                    $data->account_number,
                    new Account(),
                    new Supplier(),
                    new Treasury_transaction(),
                    new Supplier_with_order(),
                    2,
                    false
                );
                //حركة المخزن
                $items = $data->supplier_with_order_details;
                if (!empty($items)) {
                    foreach ($items as $info) {
                        //get itemcard data
                        $itemcard_data = Item_card::selection()
                            ->select('uom_id', 'retail_uom_quntToparent', 'retail_uom_id', 'does_has_retailunit')
                            ->with('uom')
                            ->where('id', $info->item_card_id)->first();
                        if (!empty($itemcard_data)) {
                            //جلب كمية الصنف قبل الحركة
                            $quantity_befor_move = Itemcard_batche::selection()->where('item_card_id', $info->item_card_id)->sum('quantity');
                            $quantity_befor_move_store = Itemcard_batche::selection()->where(['item_card_id' => $info->item_card_id, 'store_id' => $data->store_id])->sum('quantity');
                            $master_uom_name = $itemcard_data->uom->name;
                            if ($info->is_master_uom == 1) {
                                $quantity = $info->deliverd_quantity * 1;
                                $unit_price = $info->unit_price;
                            } else {
                                $quantity = $info->deliverd_quantity / $itemcard_data->retail_uom_quntToparent;
                                $unit_price = $info->unit_price * $itemcard_data->retail_uom_quntToparent;
                            }
                            if ($info->item_type == 2) {
                                $data_insert_batche['store_id'] = $data->store_id;
                                $data_insert_batche['item_card_id'] = $info->item_card_id;
                                $data_insert_batche['pro_date'] = $info->pro_date;
                                $data_insert_batche['exp_date'] = $info->ex_date;
                                $data_insert_batche['unit_cost_price'] = $unit_price;
                                $data_insert_batche['uom_id'] = $itemcard_data->uom_id;
                            } else {
                                $data_insert_batche['store_id'] = $data->store_id;
                                $data_insert_batche['item_card_id'] = $info->item_card_id;
                                $data_insert_batche['unit_cost_price'] = $unit_price;
                                $data_insert_batche['uom_id'] = $itemcard_data->uom_id;
                            }
                            $old_batch = Itemcard_batche::selection()
                                ->select('quantity', 'total_cost_price', 'id', 'added_by')
                                ->where($data_insert_batche)->first();
                            //return $old_batch;
                            if (!empty($old_batch)) {
                                $data_update_batch['quantity'] = $old_batch['quantity'] + $quantity;
                                $data_update_batch['total_cost_price'] = $old_batch['total_cost_price'] + $info->total_price;
                                $data_update_batch['updated_by'] = auth()->user()->id;
                                $data_insert_batche['updated_at'] = date('Y-m-d:H:i:s');
                                Itemcard_batche::selection()
                                    ->where('id', $old_batch->id)
                                    ->update($data_update_batch);
                            } else {
                                $data_insert_batche['quantity'] = $quantity;
                                $data_insert_batche['total_cost_price'] = $info->total_price;
                                $data_insert_batche['is_send_to_archived'] = 0;
                                $data_insert_batche['com_code'] = auth()->user()->com_code;
                                $data_insert_batche['added_by'] = auth()->user()->id;
                                $data_insert_batche['date'] = date('Y-m-d');
                                $data_insert_batche['created_at'] = date('Y-m-d:H:i:s');
                                //set auto serial
                                $row = Itemcard_batche::Selection()->orderby('id', 'DESC')->first();

                                if (!$row) {
                                    $data_insert_batche['auto_serial'] = 1;
                                } else {
                                    $data_insert_batche['auto_serial'] = $row->auto_serial + 1;
                                }
                                Itemcard_batche::insert($data_insert_batche);
                            }
                            $quantity_after_move = Itemcard_batche::selection()->where('item_card_id', $info->item_card_id)->sum('quantity');
                            $quantity_after_move_store = Itemcard_batche::selection()->where(['item_card_id' => $info->item_card_id, 'store_id' => $data->store_id])->sum('quantity');
                            //حركة الصنف
                            $data_itemcard_movements['itemcard_movement_category_id'] = 1;
                            $data_itemcard_movements['itemcard_movement_type_id'] = 1;
                            $data_itemcard_movements['store_id'] = $data->store_id;
                            $data_itemcard_movements['item_card_id'] = $info->item_card_id;
                            $data_itemcard_movements['FK_table'] = $data->id;
                            $data_itemcard_movements['FK_table_details'] = $info->id;
                            $data_itemcard_movements['byan'] = 'نظير مشتريات من المورد' . '(' . $supplier_name . ')' . 'فاتورة رقم' . '(' . $data->auto_serial . ')';
                            $data_itemcard_movements['quantity_befor_move'] = 'عدد' . '(' . ($quantity_befor_move * 1) . ')' . $master_uom_name;
                            $data_itemcard_movements['quantity_befor_move_store'] = 'عدد' . '(' . ($quantity_befor_move_store * 1) . ')' . $master_uom_name;
                            $data_itemcard_movements['quantity_after_move'] = 'عدد' . '(' . ($quantity_after_move * 1) . ')' . $master_uom_name;
                            $data_itemcard_movements['quantity_after_move_store'] = 'عدد' . '(' . ($quantity_after_move_store * 1) . ')' . $master_uom_name;
                            $data_itemcard_movements['added_by'] = auth()->user()->id;
                            $data_itemcard_movements['date'] = date('Y-m-d');
                            $data_itemcard_movements['com_code'] = auth()->user()->com_code;
                            $data_itemcard_movements['created_at'] = date('Y-m-d:H:i:s');
                            $data_itemcard_movements['updated_at'] = date('Y-m-d:H:i:s');
                            Itemcard_movement::insert($data_itemcard_movements);
                        }
                        //تحديث سعر شراء الصنف بسعر اخر فاتورة شراء
                        if ($info->is_master_uom == 1) {
                            $data_update_itemcard_costs['cost_price'] = $info->unit_price;
                            if ($itemcard_data->does_has_retailunit == 1) {
                                $data_update_itemcard_costs['cost_price_retail'] = $info->unit_price / $itemcard_data->retail_uom_quntToparent;
                            }
                        } else {
                            $data_update_itemcard_costs['cost_price'] = $info->unit_price * $itemcard_data->retail_uom_quntToparent;
                            $data_update_itemcard_costs['cost_price_retail'] = $info->unit_price;
                        }
                        Item_card::selection()->where('id', $info->item_card_id)
                            ->update($data_update_itemcard_costs);
                        //تحديث مراة الصنف الرئيسية
                        $this->do_update_itemcard_quantity(new Itemcard_batche, new Item_card, $info->item_card_id, $itemcard_data->retail_uom_quntToparent, $info->is_master_uom);
                    }
                }
                session()->flash('success', 'تم اعتماد الفاتورة بنجاح');
                return redirect()->back();
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }
    public function ajax_search(Request $request)
    {
        try {
            if ($request->ajax()) {
                $search_by_text = $request->search_by_text;
                $supplier_id_search = $request->supplier_id_search;
                $store_id_search = $request->store_id_search;
                $search_by_radio = $request->search_by_radio;
                $order_date_form = $request->order_date_form;
                $order_date_to = $request->order_date_to;

                if ($supplier_id_search == 'all') {
                    $field1 = 'id';
                    $operator1 = '>';
                    $value1 = '0';
                } else {
                    $field1 = 'supplier_id';
                    $operator1 = '=';
                    $value1 = $supplier_id_search;
                }
                if ($store_id_search == 'all') {
                    $field2 = 'id';
                    $operator2 = '>';
                    $value2 = '0';
                } else {
                    $field2 = 'store_id';
                    $operator2 = '=';
                    $value2 = $store_id_search;
                }
                if ($search_by_text != '') {
                    if ($search_by_radio == 'auto_serial') {
                        $field3 = 'auto_serial';
                        $operator3 = '=';
                        $value3 = $search_by_text;
                    } elseif ($search_by_radio == 'doc_no') {
                        $field3 = 'doc_no';
                        $operator3 = '=';
                        $value3 = $search_by_text;
                    } else {
                        $field3 = 'id';
                        $operator3 = '>';
                        $value3 = '0';
                    }
                } else {
                    $field3 = 'id';
                    $operator3 = '>';
                    $value3 = '0';
                }
                if ($order_date_form == '') {
                    $field4 = 'id';
                    $operator4 = '>';
                    $value4 = '0';
                } else {
                    $field4 = 'order_date';
                    $operator4 = '>=';
                    $value4 = $order_date_form;
                }
                if ($order_date_to == '') {
                    $field5 = 'id';
                    $operator5 = '>';
                    $value5 = '0';
                } else {
                    $field5 = 'order_date';
                    $operator5 = '<=';
                    $value5 = $order_date_to;
                }
                $data = Supplier_with_order::selection()
                    ->with('supplier', 'store', 'supplier_with_order_details')
                    ->where($field1, $operator1, $value1)
                    ->where($field2, $operator2, $value2)
                    ->where($field3, $operator3, $value3)
                    ->where($field4, $operator4, $value4)
                    ->where($field5, $operator5, $value5)
                    ->orderBy('id', 'DESC')
                    ->paginate(PAGINATION_COUNT);
                $data = $this->added_byAndUpdated_by_array($data);

                return view('admin.supplier_with_orders.ajax_search', compact('data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }
}
