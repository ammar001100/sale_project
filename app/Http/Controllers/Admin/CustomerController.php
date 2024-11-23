<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Account;
use App\Models\Customer;
use App\Models\General_setting;
use App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        try {
            $data = Customer::Selection()->with(['parentAccuont', 'accuont'])->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);

            return view('admin.customers.index', compact('data'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            return view('admin.customers.create');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function store(CustomerRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            if ($request->has('photo')) {
                //validate image
                $request->validate([
                    'photo' => 'required | mimes:png,jpg,jpeg | max:2000',
                ]);
                //save image by Traits
                $image_path = $this->saveImage($request->photo, 'customers_imgs');
                $data_insert['photo'] = $image_path;
            } else {
                $data_insert['photo'] = 'default.png';
            }
            //get customer parent account_id
            $general_setting = General_setting::where('com_code', $com_code)->first();

            //return $general_setting;
            if (empty($general_setting->customer_parent_account_id) or $general_setting->customer_parent_account_id <= 0) {
                session()->flash('error', 'الرجاء انشاء الحساب المالي للعملاء في (الحسابات المالية) و تحديده في (الضبط العام) ثم انشاء العميل');

                return redirect()->back()->withInput();
            } else {
                $data_insert_account['account_id'] = $general_setting->customer_parent_account_id;
            }
            //check exist name
            $checkExists = Customer::Selection()->where(['name' => $request->name])->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم العميل موجود بالفعل');

                return redirect()->back()->withInput();
            }
            //set customer code
            $row = Customer::Selection()->first();

            //return $row;
            if (!$row) {
                $data_insert['customer_code'] = 1;
            } else {
                $data_insert['customer_code'] = $row->customer_code + 1;
            }
            //set account number
            $row = Account::Selection()->orderby('id', 'DESC')->first();
            if (!$row) {
                $data_insert['account_number'] = 1;

            } else {
                $data_insert['account_number'] = $row->account_number + 1;
            }
            $data_insert['name'] = $request->name;
            $data_insert['phone'] = $request->phone;
            $data_insert['address'] = $request->address;
            $data_insert['start_balance_status'] = $request->start_balance_status;
            if ($data_insert['start_balance_status'] == 1) {
                if ($request->start_balance < 0 or $request->start_balance == 0) {
                    session()->flash('error', 'من فضلك ادخل رصيد اول مدة من غير سالب و ان لا يكون صفر في حالة دائن');

                    return redirect()->back()->withInput();
                } else {
                    $data_insert['start_balance'] = $request->start_balance * (-1);
                    $data_insert['current_balance'] = $request->start_balance * (-1);
                }
            } elseif ($data_insert['start_balance_status'] == 2) {
                if ($request->start_balance < 0 or $request->start_balance == 0) {
                    session()->flash('error', 'من فضلك ادخل رصيد من غير سالب وان لا يكون صفر في حالة مدين');

                    return redirect()->back()->withInput();
                } else {
                    $data_insert['start_balance'] = $request->start_balance * (1);
                    $data_insert['current_balance'] = $request->start_balance * (1);
                }
            } elseif ($data_insert['start_balance_status'] == 3) {
                $data_insert['start_balance'] = '0';
            } else {
                $data_insert['start_balance'] = '0';
            }
            $data_insert['active'] = $request->active;
            $data_insert['notes'] = $request->notes;
            $data_insert['com_code'] = $com_code;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['date'] = date('Y-m-d');
            $flag = Customer::create($data_insert);
            if ($flag) {
                //insert into accounts
                $data_insert_account['name'] = $request->name;
                $data_insert_account['account_number'] = $data_insert['account_number'];
                $data_insert_account['account_type_id'] = 3;
                $data_insert_account['start_balance_status'] = $request->start_balance_status;
                if ($data_insert_account['start_balance_status'] == 1) {
                    $data_insert_account['start_balance'] = $request->start_balance * (-1);
                    $data_insert_account['current_balance'] = $request->start_balance * (-1);
                } elseif ($data_insert_account['start_balance_status'] == 2) {
                    $data_insert_account['start_balance'] = $request->start_balance * (1);
                    $data_insert_account['current_balance'] = $request->start_balance * (1);
                } elseif ($data_insert_account['start_balance_status'] == 3) {
                    $data_insert_account['start_balance'] = '0';
                } else {
                    $data_insert_account['start_balance'] = '0';
                }
                $data_insert_account['is_parent'] = 1;
                $data_insert_account['other_table_FK'] = $data_insert['customer_code'];
                if ($request->active == 1) {
                    $is_archived = 0;
                } else {
                    $is_archived = 1;
                }
                $data_insert_account['is_archived'] = $is_archived;
                $data_insert_account['notes'] = $request->notes;
                $data_insert_account['com_code'] = $com_code;
                $data_insert_account['added_by'] = auth()->user()->id;
                $data_insert_account['date'] = date('Y-m-d');
                Account::create($data_insert_account);
            }
            session()->flash('success', 'تم اضافة العميل و حساب العميل بنجاح');

            return redirect()->route('customers.index');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        try {
            $data = Customer::selection()->find($id);
            if ($data == null) {
                session()->flash('error', 'عفوا هذه العميل غير موجوده');

                return redirect()->back();
            } else {
                return view('admin.customers.edit', compact('data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function update(CustomerUpdateRequest $request, string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Customer::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا هذه العميل غير موجود');

                return redirect()->back()->withInput();
            }
            if ($request->has('photo') and $request->photo != $data->photo) {
                //validate image
                $request->validate([
                    'photo' => 'required | mimes:png,jpg,jpeg | max:2000',
                ]);
                //save image by Traits
                $image_path = $this->saveImage($request->photo, 'customers_imgs');
                if ($data->photo != 'default.png') {
                    Storage::disk('customers_imgs')->delete($data->photo);
                }
                $data_update['photo'] = $image_path;
            }
            //check exist name
            $checkExists = Customer::Selection()->where(['name' => $request->name])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم العميل موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_update['name'] = $request->name;
            $data_update['address'] = $request->address;
            $data_update['phone'] = $request->phone;
            $data_update['active'] = $request->active;
            $data_update['notes'] = $request->notes;
            $data_update['com_code'] = $com_code;
            $data_update['updated_by'] = auth()->user()->id;
            $flag = Customer::Selection()->where(['id' => $id])->update($data_update);
            if ($flag) {
                //update accounts
                if ($request->active == 1) {
                    $is_archived = 0;
                } else {
                    $is_archived = 1;
                }
                $data_update_account['name'] = $request->name;
                $data_update_account['updated_by'] = auth()->user()->id;
                $data_update_account['notes'] = $request->notes;
                $data_update_account['is_archived'] = $is_archived;
                Account::Selection()->where(['account_number' => $data->account_number, 'other_table_FK' => $data->customer_code, 'account_type_id' => '3'])->update($data_update_account);
            }
            session()->flash('success', 'تم تحديث بيانات العميل بنجاح');

            return redirect()->route('customers.index');
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
                $search_by_radio = $request->search_by_radio;
                if ($search_by_text != '') {
                    if ($search_by_radio == 'account_number') {
                        $field1 = 'account_number';
                        $operator1 = '=';
                        $value1 = $search_by_text;
                    } elseif ($search_by_radio == 'customer_code') {
                        $field1 = 'customer_code';
                        $operator1 = '=';
                        $value1 = $search_by_text;
                    } elseif ($search_by_radio == 'name') {
                        $field1 = 'name';
                        $operator1 = 'LIKE';
                        $value1 = "%{$search_by_text}%";
                    } else {
                        $field1 = 'id';
                        $operator1 = '>';
                        $value1 = '0';
                    }
                } else {
                    $field1 = 'id';
                    $operator1 = '>';
                    $value1 = '0';
                }
                $data = Customer::Selection()
                    ->with(['parentAccuont', 'accuont'])
                    ->where($field1, $operator1, $value1)
                    ->paginate(PAGINATION_COUNT);
                $data = $this->added_byAndUpdated_by_array($data);

                return view('admin.customers.ajax_search', compact('data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Customer::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا هذه العميل غير موجود');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف بيانات العميل بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }
}
