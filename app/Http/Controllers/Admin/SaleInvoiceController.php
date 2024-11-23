<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\Itemcard_batche;
use App\Models\Itemcard_movement;
use App\Models\Item_card;
use App\Models\Sales_matrial_type;
use App\Models\Sale_invoice;
use App\Models\Sale_invoice_detail;
use App\Models\Store;
use App\Models\Treasury;
use App\Models\Treasury_transaction;
use App\Models\Uom;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class SaleInvoiceController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        try {
            $data = Sale_invoice::selection()
                ->with('customer', 'sales_matrial_type', 'delegate')
                ->select('*')
                ->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);
            $customers = Customer::SelectionActive()->get();
            $delegates = Delegate::SelectionActive()->get();
            $item_cards = Item_card::active()->get();
            $stores = Store::SelectionActive()->get();
            //check if admin has open shift or not
            $admin_shift = $this->get_user_shift();
            $sales_matrial_types = Sales_matrial_type::SelectionActive()->get();
/*            if (empty($admin_shift)) {
session()->flash('error', 'عفوا لا يوجد لديك شفت مفتوح حاليا');

return redirect()->back();
}
 */
            $money = $this->get_current_balance();
/*            if ($money == false) {
session()->flash('error', 'عفوا بيانات الشفت او الخزنة غير موجودة');

return redirect()->back();
}
 */

            return view('admin.sale_invoices.index', compact('data', 'item_cards', 'customers', 'delegates', 'stores', 'admin_shift', 'money', 'sales_matrial_types'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            //first check for pill type state cash
            if ($request->pill_type == 1) {
                if ($request->what_paid != $request->total_cost) {
                    session()->flash('error', 'عفوا يجب ان يكون المبلغ مدفوع كاملا في حالة نوع تافاتورة كاش');
                    return redirect()->back();
                }
                if ($request->what_paid > $request->total_cost) {
                    session()->flash('error', 'عفوا المبلغ المدفوع اكبر من اجمالي الفاتورة');
                    return redirect()->back();
                }
                $dataUpdateParent['what_paid'] = $request->what_paid;
            }
            if ($request->pill_type == 2) {
                if ($request->what_paid == $request->total_cost) {
                    session()->flash('error', 'عفوا يجب ان يكون المبلغ المدفوع غير كاملا في حالة نوع تافاتورة أجل');
                    return redirect()->back();
                }
                if ($request->what_paid > $request->total_cost) {
                    session()->flash('error', 'عفوا المبلغ المدفوع اكبر من اجمالي الفاتورة');
                    return redirect()->back();
                }
            }
            if (empty($request->items_array)) {
                session()->flash('error', 'الرجاء اضافة صنف واحد على الاقل');
                return redirect()->back();
            }
            $admin_shift = $this->get_user_shift();
            //get auto last isal collect with treasury
            $treasury = Treasury::selection()->where('id', $request->treasury_id)->select('last_isal_collect')->orderby('id', 'DESC')->first();
            if (empty($treasury)) {
                session()->flash('error', 'عفوا بيانات الخزنة غير موجودة');

                return redirect()->back();
            }
            $com_code = auth()->user()->com_code;
            //set auto serial
            $row = Sale_invoice::Selection()->first();
            if (!$row) {
                $data_insert['auto_serial'] = 1;
            } else {
                $data_insert['auto_serial'] = $row->auto_serial + 1;
            }
            if ($request->is_has_customer == 1) {
                $customer = Customer::Selection()
                    ->select('name', 'account_number')
                    ->where('id', $request->customer_id)
                    ->first();
                if (!$customer) {
                    session()->flash('error', 'عفوا النظام غير قادر على الوصول لبيانات العميل');
                    return redirect()->back();
                }
                $customer_name = $customer->name;
                $customer_account_number = $customer->account_number;
                $data_insert['customer_id'] = $request->customer_id;
            } else {
                $customer_name = "بدون عميل";
                $customer_account_number = null;
                $data_insert['customer_id'] = null;
            }
            //get account number
            $delegate = Delegate::Selection()->where('id', $request->delegate_id)->first();
            $batch_data = Itemcard_batche::Selection()->where('id', $request->itemcard_batche)->first();
            if (empty($batch_data) or $batch_data->quantity < $request->quentity) {
                session()->flash('error', 'عفوا الكمية المطلوبة اكبر من الكمية الموجودة بالمخزن');
                return redirect()->back();
            }
            if (!$delegate) {
                session()->flash('error', 'عفوا النظام غير قادر على الوصول لبيانات المندوب');
                return redirect()->back();
            }
            $data_insert['invoice_date'] = $request->invoice_date;
            $data_insert['delegate_id'] = $request->delegate_id;
            $data_insert['sales_matrial_type_id'] = $request->sales_matrial_type_id;
            $data_insert['is_has_customer'] = $request->is_has_customer;
            $data_insert['account_number'] = $customer_account_number;
            $data_insert['discount_type'] = $request->discount_type;
            if ($request->discount_percent != null) {
                $data_insert['discount_percent'] = $request->discount_percent;
            }
            if ($request->discount_value != null) {
                $data_insert['discount_value'] = $request->discount_value;
            }
            if ($request->tax_percent != null) {
                $data_insert['tax_percent'] = $request->tax_percent;
            }
            if ($request->tax_value != null) {
                $data_insert['tax_value'] = $request->tax_value;
            }
            $data_insert['total_befor_discount'] = $request->total_befor_discount;
            $data_insert['total_cost'] = $request->total_cost;
            $data_insert['total_cost_items'] = $request->total_cost_items;
            $data_insert['what_paid'] = $request->what_paid;
            $data_insert['what_remain'] = $request->what_remain;
            $data_insert['pill_type'] = $request->pill_type;
            $data_insert['money_for_account'] = $request->total_cost * 1;
            $data_insert['is_approved'] = 1;
            $data_insert['notes'] = $request->notes;
            $data_insert['active'] = 1;
            $data_insert['com_code'] = $com_code;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['date'] = date('Y-m-d');
            $flag = Sale_invoice::create($data_insert);
            if ($flag) {
                //action
                $money = $this->get_current_balance();
                if ($money == false) {
                    session()->flash('error', 'عفوا بيانات الشفت او الخزنة غير موجودة');
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
                $data_insert_transaction['mov_type_id'] = 10;
                $data_insert_transaction['account_id'] = $customer_account_number;
                $data_insert_transaction['money'] = $request->what_paid; //دائن
                $data_insert_transaction['mov_date'] = date('Y-m-d');
                $data_insert_transaction['is_approved'] = 1;
                $data_insert_transaction['is_account'] = 1;
                $data_insert_transaction['approved_by'] = auth()->user()->id;
                $data_insert_transaction['money_for_account'] = $request->what_paid * (-1); //دائن
                $data_insert_transaction['byan'] = 'تحصيل نظير مبيعات من العميل' . '(' . ($customer_name) . ')' . ' فاتورة رقم ' . '(' . ($flag->auto_serial) . ')';
                $data_insert_transaction['added_by'] = auth()->user()->id;
                $data_insert_transaction['date'] = date('Y-m-d');
                $data_insert_transaction['com_code'] = auth()->user()->com_code;
                $data_insert_transaction['the_foregin_key'] = $flag->id;
                $flag_transaction = Treasury_transaction::create($data_insert_transaction);
                if ($flag_transaction) {
                    Treasury::selection()->where('id', $request->treasury_id)
                        ->update(['last_isal_exhcange' => $data_insert_transaction['isal_number']]);
                }

                foreach ($request->items_array as $info) {
                    $item_data = Item_card::Selection()
                        ->where('id', $info['item_card_id'])
                        ->select('uom_id', 'retail_uom_quntToparent', 'retail_uom_id', 'does_has_retailunit')
                        ->with('uom')
                        ->first();
                    if (!$item_data) {
                        session()->flash('error', 'عفوا النظام غير قادر على الوصول لبيانات الصنف');
                        return redirect()->back();
                    } else {
                        $master_uom_name = $item_data->uom->name;

                        $data_insert_item['invoice_date'] = $request->invoice_date;
                        $data_insert_item['sale_invoice_id'] = $flag->id;
                        $data_insert_item['item_card_id'] = $info['item_card_id'];
                        $data_insert_item['store_id'] = $info['store_id'];
                        $data_insert_item['sale_item_type'] = $info['sales_type'];
                        $data_insert_item['uom_id'] = $info['uom_id'];
                        $data_insert_item['batch_id'] = $info['itemcard_batche'];
                        $data_insert_item['quantity'] = $info['quentity'];
                        $data_insert_item['unit_price'] = $info['unit_cost_price'];
                        $data_insert_item['is_bounce_or_other'] = $info['is_bounce_or_other'];
                        $data_insert_item['total_price'] = $info['total_price'];
                        $data_insert_item['is_master_uom'] = $info['is_parent_uom'];
                        $data_insert_item['com_code'] = $com_code;
                        $data_insert_item['added_by'] = auth()->user()->id;
                        $data_insert_item['date'] = date('Y-m-d');
                        $flag_item = Sale_invoice_detail::create($data_insert_item);
                        if ($flag_item) {
                            //جلب كمية الصنف قبل الحركة
                            $quantity_befor_move = Itemcard_batche::selection()->where('item_card_id', $info['item_card_id'])->sum('quantity');
                            $quantity_befor_move_store = Itemcard_batche::selection()->where(['item_card_id' => $info['item_card_id'], 'store_id' => $info['store_id']])->sum('quantity');
                            //خصم الكمية من الباتش
                            $data_update_batch['quantity'] = $batch_data['quantity'] - $info['quentity'];
                            $data_update_batch['total_cost_price'] = $batch_data['total_cost_price'] - $info['total_price'];
                            $data_update_batch['updated_by'] = auth()->user()->id;
                            $data_insert_batche['updated_at'] = date('Y-m-d:H:i:s');
                            $flag_item_batch = Itemcard_batche::selection()
                                ->where('id', $batch_data->id)
                                ->update($data_update_batch);
                            //جلب الكمية بعد التعديل
                            if ($flag_item_batch) {
                                $quantity_after_move = Itemcard_batche::selection()->where('item_card_id', $info['item_card_id'])->sum('quantity');
                                $quantity_after_move_store = Itemcard_batche::selection()->where(['item_card_id' => $info['item_card_id'], 'store_id' => $info['store_id']])->sum('quantity');
                                //حركة الصنف
                                $data_itemcard_movements['itemcard_movement_category_id'] = 2;
                                $data_itemcard_movements['itemcard_movement_type_id'] = 4;
                                $data_itemcard_movements['store_id'] = $info['store_id'];
                                $data_itemcard_movements['item_card_id'] = $info['item_card_id'];
                                $data_itemcard_movements['FK_table'] = $flag->id;
                                $data_itemcard_movements['FK_table_details'] = $flag_item->id;
                                $data_itemcard_movements['byan'] = 'نظير مبيعات للعميل' . '(' . $customer_name . ')' . 'فاتورة رقم' . '(' . $flag->auto_serial . ')';
                                $data_itemcard_movements['quantity_befor_move'] = 'عدد' . '(' . ($quantity_befor_move * 1) . ')' . $master_uom_name;
                                $data_itemcard_movements['quantity_befor_move_store'] = 'عدد' . '(' . ($quantity_befor_move_store * 1) . ')' . $master_uom_name;
                                $data_itemcard_movements['quantity_after_move'] = 'عدد' . '(' . ($quantity_after_move * 1) . ')' . $master_uom_name;
                                $data_itemcard_movements['quantity_after_move_store'] = 'عدد' . '(' . ($quantity_after_move_store * 1) . ')' . $master_uom_name;
                                $data_insert_transaction['is_approved'] = 1;
                                $data_insert_transaction['is_account'] = 1;
                                $data_itemcard_movements['added_by'] = auth()->user()->id;
                                $data_itemcard_movements['date'] = date('Y-m-d');
                                $data_itemcard_movements['com_code'] = auth()->user()->com_code;
                                $data_itemcard_movements['created_at'] = date('Y-m-d:H:i:s');
                                $data_itemcard_movements['updated_at'] = date('Y-m-d:H:i:s');
                                Itemcard_movement::insert($data_itemcard_movements);

                                //تحديث مراة الصنف الرئيسية
                                $this->do_update_itemcard_quantity(
                                    new Itemcard_batche,
                                    new Item_card,
                                    $info['item_card_id'],
                                    $item_data->retail_uom_quntToparent,
                                    $info['is_parent_uom']
                                );
                            }
                        }
                        if ($request->is_has_customer == 1) {
                            //التأثير في حساب عميل
                            $this->refresh_account_blance(
                                $customer_account_number,
                                new Account(),
                                new Customer(),
                                new Treasury_transaction(),
                                new Sale_invoice(),
                                3,
                                false
                            );
                        }
                    }
                }
                session()->flash('success', 'تم اضافة فاتورة المبيعات بنجاح');
                return redirect()->back();
            } else {
                session()->flash('error', 'حدث خطاء ما ');
                return redirect()->back();
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());
            return redirect()->back();
        }
    }

    public function store_test(Request $request)
    {
        try {
            if ($request->ajax()) {
                $com_code = auth()->user()->com_code;
                //set auto serial
                $row = Sale_invoice::Selection()->first();
                if (!$row) {
                    $data_insert['auto_serial'] = 1;
                } else {
                    $data_insert['auto_serial'] = $row->auto_serial + 1;
                }
                $customer = Customer::Selection()->where('id', $request->customer_id)->first();
                if (!$customer) {
                    session()->flash('error', 'عفوا النظام غير قادر على الوصول لبيانات العميل');
                }
                //get account number
                $delegate = Delegate::Selection()->where('id', $request->delegate_id)->first();
                if (!$delegate) {
                    session()->flash('error', 'عفوا النظام غير قادر على الوصول لبيانات المندوب');
                }
                $data_insert['invoice_date'] = $request->invoice_date;
                $data_insert['customer_id'] = $request->customer_id;
                $data_insert['delegate_id'] = $request->delegate_id;
                $data_insert['sales_matrial_type_id'] = $request->sales_matrial_type_id;
                $data_insert['is_has_customer'] = $request->is_has_customer;
                $data_insert['account_number'] = $request->account_number;
                $data_insert['pill_type'] = $request->pill_type;
                $data_insert['com_code'] = $com_code;
                $data_insert['added_by'] = auth()->user()->id;
                $data_insert['date'] = date('Y-m-d');
                $flag = Sale_invoice::create($data_insert);
                if (!$flag) {
                    echo json_encode($flag);
                } else {
                    echo json_encode($request->item_card_id_array);
                }

                // return view('admin.sale_invoices.get_add_new_item_row', compact('recleved_data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function show(string $id)
    {
        try {
            $data = Sale_invoice::selection()->with('sale_inv_details', 'delegate')->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا فاتورة المشتريات غير موجودة');

                return redirect()->route('supplier_orders.index');
            }
            $data = $this->added_byAndUpdated_by($data);

            $sale_inv_details = $data->sale_inv_details()->with('item_cards')->get();
            //return $data->supplier_with_order_details()->with('item_card')->get();

            return view('admin.sale_invoices.show', compact('data', 'sale_inv_details'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function edit(string $id)
    {
        session()->flash('error', 'لا توجد نتيجة');

        return redirect()->back();
        try {
            $data = Sale_invoice::selection()
                ->where('id', $id)
                ->with('customer', 'sales_matrial_type', 'delegate', 'sale_inv_details')
                ->select('*')
                ->first();
            $data = $this->added_byAndUpdated_by($data);
            $customers = Customer::SelectionActive()->get();
            $delegates = Delegate::SelectionActive()->get();
            $item_cards = Item_card::active()->get();
            $stores = Store::SelectionActive()->get();
            //check if admin has open shift or not
            $admin_shift = $this->get_user_shift();
            $sales_matrial_types = Sales_matrial_type::SelectionActive()->get();
            if (empty($admin_shift)) {
                session()->flash('error', 'عفوا لا يوجد لديك شفت مفتوح حاليا');

                return redirect()->back();
            }
            $money = $this->get_current_balance();
            if ($money == false) {
                session()->flash('error', 'عفوا بيانات الشفت او الخزنة غير موجودة');

                return redirect()->back();
            }

            return view('admin.sale_invoices.edit', compact('data', 'item_cards', 'customers', 'delegates', 'stores', 'admin_shift', 'money', 'sales_matrial_types', ));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function ajax_get_uom(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Item_card::selection()->with(['retail_uom', 'uom'])->find($request->item_card_id);

                return view('admin.sale_invoices.ajax_get_uom', compact('data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function ajax_get_uom_(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Item_card::selection()->with(['retail_uom', 'uom'])->find($request->item_card_id);

                return view('admin.sale_invoices.ajax_get_uom_', compact('data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function get_item_card_batches(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data_Item_card = Item_card::selection()->select('item_type', 'retail_uom_quntToparent')->find($request->item_card_id);
                $uom_id = $request->uom_id;
                $store_id = $request->store_id;
                $data_uom = Uom::selection()->select('name', 'is_master')->where('id', $uom_id)->first();
                if (!empty($data_uom)) {
                    if ($data_Item_card->item_type == 2) {
                        $data = Itemcard_batche::selection()->where(['item_card_id' => $request->item_card_id, 'store_id' => $store_id])
                            ->orderby('id', 'ASC')
                            ->get();
                    } else {
                        $data = Itemcard_batche::selection()->where(['item_card_id' => $request->item_card_id, 'store_id' => $store_id])
                            ->orderby('id', 'ASC') //DESC
                            ->get();
                    }

                    return view('admin.sale_invoices.ajax_get_item_card_batches', compact('data', 'data_uom', 'data_Item_card'));
                }
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function get_item_card_batches_(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data_Item_card = Item_card::selection()->select('item_type', 'retail_uom_quntToparent')->find($request->item_card_id);
                $uom_id = $request->uom_id;
                $store_id = $request->store_id;
                $data_uom = Uom::selection()->select('name', 'is_master')->where('id', $uom_id)->first();
                if (!empty($data_uom)) {
                    if ($data_Item_card->item_type == 2) {
                        $data = Itemcard_batche::selection()->where(['item_card_id' => $request->item_card_id, 'store_id' => $store_id])
                            ->orderby('id', 'ASC')
                            ->get();
                    } else {
                        $data = Itemcard_batche::selection()->where(['item_card_id' => $request->item_card_id, 'store_id' => $store_id])
                            ->orderby('id', 'ASC') //DESC
                            ->get();
                    }

                    return view('admin.sale_invoices.ajax_get_item_card_batches_', compact('data', 'data_uom', 'data_Item_card'));
                }
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function get_unit_cost_price(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data_Item_card = Item_card::selection()
                    ->select(
                        'uom_id',
                        'retail_uom_id',
                        'does_has_retailunit',
                        'price',
                        'nos_gomal_price',
                        'gomal_price',
                        'price_retail',
                        'nos_gomal_price_retail',
                        'gomal_price_retail',
                    )
                    ->find($request->item_card_id);
                $data_uom = Uom::selection()
                    ->select('id', 'is_master')
                    ->where('id', $request->uom_id)
                    ->first();
                if (!empty($data_uom)) {
                    if ($data_uom->is_master == 1) {
                        if ($data_Item_card->uom_id == $data_uom->id) {
                            if ($request->sales_type == 1) {
                                echo json_encode($data_Item_card->price);
                            } elseif ($request->sales_type == 2) {
                                echo json_encode($data_Item_card->nos_gomal_price);
                            } else {
                                echo json_encode($data_Item_card->gomal_price);
                            }
                        } else {
                            session()->flash('عفوا الوحدة لا تنتمي للصنف');
                        }
                    } else {
                        if ($data_Item_card->retail_uom_id == $data_uom->id and $data_Item_card->does_has_retailunit == 1) {
                            if ($request->sales_type == 1) {
                                echo json_encode($data_Item_card->price_retail);
                            } elseif ($request->sales_type == 2) {
                                echo json_encode($data_Item_card->nos_gomal_price_retail);
                            } else {
                                echo json_encode($data_Item_card->gomal_price_retail);
                            }
                        } else {
                            session()->flash('عفوا الوحدة لا تنتمي للصنف');
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function get_unit_cost_price_(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data_Item_card = Item_card::selection()
                    ->select(
                        'uom_id',
                        'retail_uom_id',
                        'does_has_retailunit',
                        'price',
                        'nos_gomal_price',
                        'gomal_price',
                        'price_retail',
                        'nos_gomal_price_retail',
                        'gomal_price_retail',
                    )
                    ->find($request->item_card_id);
                $data_uom = Uom::selection()
                    ->select('id', 'is_master')
                    ->where('id', $request->uom_id)
                    ->first();
                if (!empty($data_uom)) {
                    if ($data_uom->is_master == 1) {
                        if ($data_Item_card->uom_id == $data_uom->id) {
                            if ($request->sales_type == 1) {
                                echo json_encode($data_Item_card->price);
                            } elseif ($request->sales_type == 2) {
                                echo json_encode($data_Item_card->nos_gomal_price);
                            } else {
                                echo json_encode($data_Item_card->gomal_price);
                            }
                        } else {
                            session()->flash('عفوا الوحدة لا تنتمي للصنف');
                        }
                    } else {
                        if ($data_Item_card->retail_uom_id == $data_uom->id and $data_Item_card->does_has_retailunit == 1) {
                            if ($request->sales_type == 1) {
                                echo json_encode($data_Item_card->price_retail);
                            } elseif ($request->sales_type == 2) {
                                echo json_encode($data_Item_card->nos_gomal_price_retail);
                            } else {
                                echo json_encode($data_Item_card->gomal_price_retail);
                            }
                        } else {
                            session()->flash('عفوا الوحدة لا تنتمي للصنف');
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function get_new_item_row(Request $request)
    {
        try {
            if ($request->ajax()) {
                $recleved_data['item_card_id'] = $request->item_card_id;
                $recleved_data['store_id'] = $request->store_id;
                $recleved_data['sales_type'] = $request->sales_type;
                $recleved_data['uom_id'] = $request->uom_id;
                $recleved_data['itemcard_batche'] = $request->itemcard_batche;
                $recleved_data['quentity'] = $request->quentity;
                $recleved_data['unit_cost_price'] = $request->unit_cost_price;
                $recleved_data['is_bounce_or_other'] = $request->is_bounce_or_other;
                $recleved_data['total_price'] = $request->total_price;
                $recleved_data['item_card_name'] = $request->item_card_name;
                $recleved_data['store_name'] = $request->store_name;
                $recleved_data['uom_name'] = $request->uom_name;
                $recleved_data['sales_type_name'] = $request->sales_type_name;
                $recleved_data['is_bounce_or_other_name'] = $request->is_bounce_or_other_name;
                $recleved_data['is_parent_uom'] = $request->is_parent_uom;
                $recleved_data['index'] = $request->index;

                return view('admin.sale_invoices.get_add_new_item_row', compact('recleved_data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function get_new_item_row_(Request $request)
    {
        try {
            if ($request->ajax()) {
                $recleved_data['item_card_id'] = $request->item_card_id;
                $recleved_data['store_id'] = $request->store_id;
                $recleved_data['uom_id'] = $request->uom_id;
                $recleved_data['itemcard_batche'] = $request->itemcard_batche;
                $recleved_data['quentity'] = $request->quentity;
                $recleved_data['unit_cost_price'] = $request->unit_cost_price;
                $recleved_data['is_bounce_or_other'] = $request->is_bounce_or_other;
                $recleved_data['total_price'] = $request->total_price;
                $recleved_data['item_card_name'] = $request->item_card_name;
                $recleved_data['store_name'] = $request->store_name;
                $recleved_data['uom_name'] = $request->uom_name;
                $recleved_data['sales_type_name'] = $request->sales_type_name;
                $recleved_data['is_bounce_or_other_name'] = $request->is_bounce_or_other_name;
                $recleved_data['is_parent_uom'] = $request->is_parent_uom;

                return view('admin.sale_invoices.get_add_new_item_row_', compact('recleved_data'));
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
                $customer_id_search = $request->customer_id_search;
                $delegate_id_search = $request->delegate_id_search;
                $pill_type_search = $request->pill_type_search;
                $sales_matrial_type_id_search = $request->sales_matrial_type_id_search;
                $search_by_radio = $request->search_by_radio;
                $invoice_date_form = $request->invoice_date_form;
                $invoice_date_to = $request->invoice_date_to;

                if ($customer_id_search == 'all') {
                    $field1 = 'id';
                    $operator1 = '>';
                    $value1 = '0';
                } elseif ($customer_id_search == 'without') {
                    $field1 = 'customer_id';
                    $operator1 = '=';
                    $value1 = null;
                } else {
                    $field1 = 'customer_id';
                    $operator1 = '=';
                    $value1 = $customer_id_search;
                }
                if ($delegate_id_search == 'all') {
                    $field2 = 'id';
                    $operator2 = '>';
                    $value2 = '0';
                } else {
                    $field2 = 'delegate_id';
                    $operator2 = '=';
                    $value2 = $delegate_id_search;
                }
                if ($pill_type_search == 'all') {
                    $field3 = 'id';
                    $operator3 = '>';
                    $value3 = '0';
                } else {
                    $field3 = 'pill_type';
                    $operator3 = '=';
                    $value3 = $pill_type_search;
                }
                if ($sales_matrial_type_id_search == 'all') {
                    $field4 = 'id';
                    $operator4 = '>';
                    $value4 = '0';
                } else {
                    $field4 = 'sales_matrial_type_id';
                    $operator4 = '=';
                    $value4 = $sales_matrial_type_id_search;
                }
                if ($search_by_text != '') {
                    if ($search_by_radio == 'auto_serial') {
                        $field5 = 'auto_serial';
                        $operator5 = '=';
                        $value5 = $search_by_text;
                    } elseif ($search_by_radio == 'customer_id') {
                        $field5 = 'customer_id';
                        $operator5 = '=';
                        $value5 = $search_by_text;
                    } elseif ($search_by_radio == 'account_number') {
                        $field5 = 'account_number';
                        $operator5 = '=';
                        $value5 = $search_by_text;
                    } else {
                        $field5 = 'id';
                        $operator5 = '>';
                        $value5 = '0';
                    }
                } else {
                    $field5 = 'id';
                    $operator5 = '>';
                    $value5 = '0';
                }
                if ($invoice_date_form == '') {
                    $field6 = 'id';
                    $operator6 = '>';
                    $value6 = '0';
                } else {
                    $field6 = 'invoice_date';
                    $operator6 = '>=';
                    $value6 = $invoice_date_form;
                }
                if ($invoice_date_to == '') {
                    $field7 = 'id';
                    $operator7 = '>';
                    $value7 = '0';
                } else {
                    $field7 = 'invoice_date';
                    $operator7 = '<=';
                    $value7 = $invoice_date_to;
                }
                $data = Sale_invoice::selection()
                    ->with('customer', 'sales_matrial_type', 'delegate')
                    ->where($field1, $operator1, $value1)
                    ->where($field2, $operator2, $value2)
                    ->where($field3, $operator3, $value3)
                    ->where($field4, $operator4, $value4)
                    ->where($field5, $operator5, $value5)
                    ->where($field6, $operator6, $value6)
                    ->where($field7, $operator7, $value7)
                    ->orderBy('id', 'DESC')
                    ->paginate(PAGINATION_COUNT);
                $data = $this->added_byAndUpdated_by_array($data);

                return view('admin.sale_invoices.ajax_search', compact('data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }
}
