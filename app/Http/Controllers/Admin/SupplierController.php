<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\Account;
use App\Models\General_setting;
use App\Models\Supplier;
use App\Models\Supplier_category;
use App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Traits\GeneralTrait;

    public function index()
    {
        try {
            $data = Supplier::Selection()->with(['parentAccuont', 'accuont', 'supplierCategory'])->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);
            $supplier_category = Supplier_category::SelectionActive()->get();

            return view('admin.suppliers.index', compact('data', 'supplier_category'));
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
            $supplier_category = Supplier_category::SelectionActive()->get();

            return view('admin.suppliers.create', compact('supplier_category'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            if ($request->has('photo')) {
                //validate image
                $request->validate([
                    'photo' => 'required | mimes:png,jpg,jpeg | max:2000',
                ]);
                //save image by Traits
                $image_path = $this->saveImage($request->photo, 'suppliers_imgs');
                $data_insert['photo'] = $image_path;
            } else {
                $data_insert['photo'] = 'default.png';
            }
            //get customer parent account_id
            $general_setting = General_setting::where('com_code', $com_code)->first();

            //return $general_setting;
            if (empty($general_setting->supplier_parent_account_id) or $general_setting->supplier_parent_account_id <= 0) {
                session()->flash('error', 'الرجاء انشاء الحساب المالي للموردين في (الحسابات المالية) و تحديده في (الضبط العام) ثم انشاء المورد');

                return redirect()->back()->withInput();
            } else {
                $data_insert_account['account_id'] = $general_setting->supplier_parent_account_id;
            }
            //check exist name
            $checkExists = Supplier::Selection()->where(['name' => $request->name])->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم المورد موجود بالفعل');

                return redirect()->back()->withInput();
            }
            //set supplier code
            $row = Supplier::Selection()->orderby('id', 'DESC')->first();

            //return $row;
            if (!$row) {
                $data_insert['supplier_code'] = 1;
            } else {
                $data_insert['supplier_code'] = $row->supplier_code + 1;
            }
            //set account number
            $row = Account::Selection()->orderby('id', 'DESC')->first();
            if (!$row) {
                $data_insert['account_number'] = 1;
            } else {
                $data_insert['account_number'] = $row->account_number + 1;
            }
            $data_insert['name'] = $request->name;
            $data_insert['supplier_category_id'] = $request->supplier_category_id;
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
            $flag = Supplier::create($data_insert);
            if ($flag) {
                //insert into accounts
                $data_insert_account['name'] = $request->name;
                $data_insert_account['account_number'] = $data_insert['account_number'];
                $data_insert_account['account_type_id'] = 2;
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
                $data_insert_account['other_table_FK'] = $data_insert['supplier_code'];
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
            session()->flash('success', 'تم اضافة المورد و حساب المورد بنجاح');

            return redirect()->route('suppliers.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = Supplier::selection()->find($id);
            $supplier_category = Supplier_category::SelectionActive()->get();
            if ($data == null) {
                session()->flash('error', 'عفوا هذه المورد غير موجوده');

                return redirect()->back();
            } else {
                return view('admin.suppliers.edit', compact('data', 'supplier_category'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierUpdateRequest $request, string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Supplier::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا هذه المورد غير موجود');

                return redirect()->back()->withInput();
            }
            if ($request->has('photo') and $request->photo != $data->photo) {
                //validate image
                $request->validate([
                    'photo' => 'required | mimes:png,jpg,jpeg | max:2000',
                ]);
                //save image by Traits
                $image_path = $this->saveImage($request->photo, 'suppliers_imgs');
                if ($data->photo != 'default.png') {
                    Storage::disk('suppliers_imgs')->delete($data->photo);
                }
                $data_update['photo'] = $image_path;
            }
            //check exist name
            $checkExists = Supplier::Selection()->where(['name' => $request->name])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم المورد موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_update['name'] = $request->name;
            $data_update['supplier_category_id'] = $request->supplier_category_id;
            $data_update['address'] = $request->address;
            $data_update['phone'] = $request->phone;
            $data_update['active'] = $request->active;
            $data_update['notes'] = $request->notes;
            $data_update['com_code'] = $com_code;
            $data_update['updated_by'] = auth()->user()->id;
            $flag = Supplier::Selection()->where(['id' => $id])->update($data_update);
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
                Account::Selection()->where(['account_number' => $data->account_number, 'other_table_FK' => $data->supplier_code, 'account_type_id' => '2'])->update($data_update_account);
            }
            session()->flash('success', 'تم تحديث بيانات المورد بنجاح');

            return redirect()->route('suppliers.index');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    //SEARCH

    public function ajax_search(Request $request)
    {
        try {
            if ($request->ajax()) {
                $search_by_text = $request->search_by_text;
                $search_by_radio = $request->search_by_radio;
                $supplier_category_id = $request->supplier_category_id;
                if ($supplier_category_id == 'all') {
                    $field2 = 'id';
                    $operator2 = '>';
                    $value2 = '0';
                } else {
                    $field2 = 'supplier_category_id';
                    $operator2 = '=';
                    $value2 = $supplier_category_id;
                }
                if ($search_by_text != '') {
                    if ($search_by_radio == 'account_number') {
                        $field1 = 'account_number';
                        $operator1 = '=';
                        $value1 = $search_by_text;
                    } elseif ($search_by_radio == 'supplier_code') {
                        $field1 = 'supplier_code';
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
                $data = Supplier::Selection()
                    ->with(['parentAccuont', 'accuont'])
                    ->where($field1, $operator1, $value1)
                    ->where($field2, $operator2, $value2)
                    ->paginate(PAGINATION_COUNT);
                $data = $this->added_byAndUpdated_by_array($data);

                return view('admin.suppliers.ajax_search', compact('data'));
            }
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
            $data = Supplier::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا هذه المورد غير موجود');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف بيانات المورد بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }
}
