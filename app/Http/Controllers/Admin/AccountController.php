<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Models\Account;
use App\Models\Account_Type;
use App\Traits;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        $data = Account::Selection()->with(['parent', 'account_type'])->paginate(PAGINATION_COUNT);
        $data = $this->added_byAndUpdated_by_array($data);
        $account_Type = Account_Type::selectionActive()->select('id', 'name')->get();

        return view('admin.accounts.index', compact('data', 'account_Type'));
    }

    public function create()
    {
        try {
            $account_type = Account_Type::selectionIternal()->select('id', 'name')->get();
            $parent_account = Account::selectionIsArchivedParent()->select('id', 'name')->get();

            return view('admin.accounts.create', compact('account_type', 'parent_account'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function store(AccountRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            //check exist name
            $checkExists = Account::Selection()->where(['name' => $request->name])->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم الحساب المالي موجود بالفعل');

                return redirect()->back()->withInput();
            }
            //set account number
            $row = Account::Selection()->orderby('id', 'DESC')->first();
            if (!$row) {
                $data_insert['account_number'] = 1;

            } else {
                $data_insert['account_number'] = $row->account_number + 1;
            }
            $data_insert['name'] = $request->name;
            $data_insert['account_type_id'] = $request->account_type_id;
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
                    $data_insert['start_balance'] = $request->start_balance;
                    $data_insert['current_balance'] = $request->start_balance;
                }
            } elseif ($data_insert['start_balance_status'] == 3) {
                $data_insert['start_balance'] = '0';
            } else {
                $data_insert['start_balance'] = '0';
            }
            $data_insert['is_parent'] = $request->is_parent;
            if ($data_insert['is_parent'] != 1) {
                $data_insert['account_id'] = '0';
            } else {
                $data_insert['account_id'] = $request->account_id;
            }
            $data_insert['is_archived'] = $request->is_archived;
            $data_insert['notes'] = $request->notes;
            $data_insert['com_code'] = $com_code;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['date'] = date('Y-m-d');
            Account::create($data_insert);
            session()->flash('success', 'تم اضافة الحساب المالي بنجاح');

            return redirect()->route('accounts.index');
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
            $data = Account::selection()->with(['account_type'])->find($id);
            if (isset($data->account_type) and $data->account_type->relatedIternalAccounts == 1) {
                session()->flash('error', 'عفوا لا يمكن تديث هذا الحساب الى من شاشته الخاصة حسب نوعه');

                return redirect()->back();
            }
            $account_type = Account_Type::selection()->select('id', 'name')->get();
            $parent_account = Account::selectionIsArchivedParent()->select('id', 'name')->get();
            if ($data == null) {
                session()->flash('error', 'عفوا الحساب المالي غير موجوده');

                return redirect()->back();
            } else {
                return view('admin.accounts.edit', compact('data', 'account_type', 'parent_account'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function update(AccountUpdateRequest $request, string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Account::selection()->with(['account_type'])->find($id);
            if (isset($data->account_type) and $data->account_type->relatedIternalAccounts == 1) {
                session()->flash('error', 'عفوا لا يمكن تديث هذا الحساب الى من شاشته الخاصة حسب نوعه');

                return redirect()->back();
            }
            if (empty($data)) {
                session()->flash('error', 'عفوا الحساب المالي غير موجود');

                return redirect()->back()->withInput();
            }
            //check exist name
            $checkExists = Account::Selection()->where(['name' => $request->name])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم الحساب المالي موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_update['name'] = $request->name;
            $data_update['account_type_id'] = $request->account_type_id;
            $data_update['is_parent'] = $request->is_parent;
            if ($data_update['is_parent'] != 1) {
                $data_update['account_id'] = '0';
            } else {
                $data_update['account_id'] = $request->account_id;
            }
            $data_update['is_archived'] = $request->is_archived;
            $data_update['notes'] = $request->notes;
            $data_update['com_code'] = $com_code;
            $data_update['updated_by'] = auth()->user()->id;
            Account::Selection()->where(['id' => $id])->update($data_update);

            session()->flash('success', 'تم تحديث الحساب المالي بنجاح');

            return redirect()->route('accounts.index');
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
                $account_type_id_search = $request->account_type_id_search;
                $is_parent_search = $request->is_parent_search;
                $search_by_radio = $request->search_by_radio;
                if ($account_type_id_search == 'all') {
                    $field1 = 'id';
                    $operator1 = '>';
                    $value1 = '0';
                } else {
                    $field1 = 'account_type_id';
                    $operator1 = '=';
                    $value1 = $account_type_id_search;
                }
                if ($is_parent_search == 'all') {
                    $field2 = 'id';
                    $operator2 = '>';
                    $value2 = '0';
                } else {
                    $field2 = 'is_parent';
                    $operator2 = '=';
                    $value2 = $is_parent_search;
                }
                if ($search_by_text != '') {
                    if ($search_by_radio == 'account_number') {
                        $field3 = 'account_number';
                        $operator3 = '=';
                        $value3 = $search_by_text;
                    } elseif ($search_by_radio == 'name') {
                        $field3 = 'name';
                        $operator3 = 'LIKE';
                        $value3 = "%{$search_by_text}%";
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
                $data = Account::selection()
                    ->with(['parent', 'account_type'])
                    ->where($field1, $operator1, $value1)
                    ->where($field2, $operator2, $value2)
                    ->where($field3, $operator3, $value3)
                //->orderBy('id', 'ASC')
                    ->paginate(PAGINATION_COUNT);
                $data = $this->added_byAndUpdated_by_array($data);

                return view('admin.accounts.ajax_search', compact('data'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Account::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الحساب المالي غير موجود');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف الحساب المالي بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }
}
