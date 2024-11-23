<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExchangeTransactionRequest;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Mov_type;
use App\Models\Sale_invoice;
use App\Models\Supplier;
use App\Models\Supplier_with_order;
use App\Models\Treasury;
use App\Models\Treasury_transaction;
use App\Traits;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Traits\GeneralTrait;
    public function index()
    {
        try {
            $admin_shift = $this->get_user_shift();
            if (empty($admin_shift)) {
                session()->flash('warning', 'عفوا لا يوجد لديك شفت مفتوح الرجاء تحدبد الخزنة لبدء الشفت');

                return redirect()->route('admin_shifts.create');
            }
            $data = Treasury_transaction::Selection()
                ->where(['admin_shift_id' => $admin_shift->id])
                ->where('money', '<', '0')
                ->with('treasury', 'admin', 'mov_type')
                ->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);
            $account = Account::selection()->where(['is_archived' => 0, 'is_parent' => 1])->get();
            $money = $this->get_current_balance();
            $mov_type = Mov_type::Selection()->where(['active' => 1, 'in_screen' => 1, 'is_private_intemal' => 0])->get();
            return view('admin.exchange_transactions.index', compact('data', 'admin_shift', 'account', 'money', 'mov_type'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExchangeTransactionRequest $request)
    {
        try {
            //check if admin has open shift or not
            $admin_shift = $this->get_user_shift();
            if (empty($admin_shift)) {
                session()->flash('error', 'عفوا لا يوجد لديك شفت مفتوح حاليا');

                return redirect()->back();
            }
            //get auto last isal collect with treasury
            $treasury = Treasury::selection()->where('id', $request->treasury_id)->select('last_isal_exhcange')->orderby('id', 'DESC')->first();
            if (empty($treasury)) {
                session()->flash('error', 'عفوا بيانات الخزنة غير موجودة');

                return redirect()->back();
            }
            //set auto serial
            $row = Treasury_transaction::Selection()->orderby('id', 'DESC')->first();

            if (!$row) {
                $data_insert['auto_serial'] = 1;
            } else {
                $data_insert['auto_serial'] = $row->auto_serial + 1;
            }
            //set trans code
            $random = random_int(10000, 99999);
            $random = substr($random, 0, 5);

            $data_insert['isal_number'] = $treasury->last_isal_exhcange + 1;
            $data_insert['trans_code'] = $data_insert['isal_number'] . $random;
            $data_insert['treasury_id'] = $request->treasury_id;
            $data_insert['admin_shift_id'] = $admin_shift->id;
            $data_insert['mov_type_id'] = $request->mov_type_id;
            $data_insert['account_id'] = $request->account_id;
            $data_insert['money'] = $request->money * (-1); //مدين
            $data_insert['mov_date'] = $request->mov_date;
            $data_insert['is_approved'] = 1;
            $data_insert['is_account'] = 1;
            $data_insert['money_for_account'] = $request->money; //دائن
            $data_insert['byan'] = $request->byan;
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['date'] = date('Y-m-d');
            $data_insert['com_code'] = auth()->user()->com_code;
            $flag = Treasury_transaction::create($data_insert);
            if ($flag) {
                Treasury::selection()->where('id', $request->treasury_id)
                    ->update(['last_isal_exhcange' => $data_insert['isal_number']]);
            }
            $account = Account::selection()
                ->where('id', $request->account_id)
                ->select('account_type_id', 'account_number')
                ->first();
            //return $account;
            if ($account->account_type_id == 2) {
                $this->refresh_account_blance(
                    $account->account_number,
                    new Account(),
                    new Supplier(),
                    new Treasury_transaction(),
                    new Supplier_with_order(),
                    $account->account_type_id,
                    false
                );
            } elseif ($account->account_type_id == 3) {
                $this->refresh_account_blance(
                    $account->account_number,
                    new Account(),
                    new Customer(),
                    new Treasury_transaction(),
                    new Sale_invoice(),
                    $account->account_type_id,
                    false
                );
            } else {}

            session()->flash('success', 'تم اضافة بيانات التحصيل بنجاح');

            return redirect()->route('exchange_transactions.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
