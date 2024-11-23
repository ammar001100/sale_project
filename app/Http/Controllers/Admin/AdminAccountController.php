<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Admin_treasuries;
use App\Models\Treasury;
use App\Traits;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Traits\GeneralTrait;

    public function index()
    {
        try {
            $data = Admin::Selection()->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);

            return view('admin.admin_accounts.index', compact('data'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

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

    public function add_treasury($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Admin::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الخزنة غير موجودة');

                return redirect()->back()->withInput();
            }
            $treasuries = Treasury::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();

            return view('admin.admin_accounts.add_treasury', compact('data', 'treasuries'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function store_treasury(Request $request,$id){
    $request->validate([
        'treasury_id' => 'required',
        'active' => 'required',
    ],
    [
        'treasury_id.required' =>'الرجاء اختيار الخزنة',
        'active.required' =>'الرجاء اختيار حالة التفعيل'
    ]);
    try {
        $com_code = auth()->user()->com_code;
        $data = Admin::selection()->find($id);
        if (empty($data)) {
            session()->flash('error', 'عفوا المستخدم غير موجود');

            return redirect()->back()->withInput();
        }
        $treasury = Treasury::selection()->find($id);
        if ($treasury == null) {
            session()->flash('error', 'عفوا الخزنة غير موجودة');

            return redirect()->back()->withInput();
        }
        $checkExists = Admin_treasuries::where(['treasury_id' => $request->treasury_id, 'admin_id' => $id])->first();
        if ($checkExists != null) {
            // التاكد من موجود الخزنة
            session()->flash('error', 'الخزنة مضافة بالفعل للمستخدم');

            return redirect()->back()->withInput();
        }
        $data_insert['admin_id'] = $id;
        $data_insert['treasury_id'] = $request->treasury_id;
        $data_insert['active'] = $request->active;
        $data_insert['added_by'] = auth()->user()->id;
        $data_insert['com_code'] = $com_code;
        Admin_treasuries::create($data_insert);
        session()->flash('success', 'تم اضافة الخزنة للمستخدم بنجاح');

        return redirect()->route('admin_accounts.show',$id);
    } catch (\Exception $ex) {
        session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

        return redirect()->back();
    }
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = Admin::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا المستخدم غير موجودة');

                return redirect()->route('admin_accounts.index');
            }
            $data = $this->added_byAndUpdated_by($data);

            $treasuries = Admin_treasuries::selection()->where('admin_id', $data->id)->with('treasury')->get();
            $treasuries = $this->added_byAndUpdated_by_array($treasuries);

            return view('admin.admin_accounts.show', compact('data', 'treasuries'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
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
    public function delete_treasury(string $id){
        try {
            $data = Admin_treasuries::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا هذه الخزنة غير موجودة لدى المستخدم');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف الخزنة المضافة للمستخدم بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }
}