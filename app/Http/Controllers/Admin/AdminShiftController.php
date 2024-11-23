<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin_shifts;
use App\Models\Admin_treasuries;
use App\Traits;
use Illuminate\Http\Request;

class AdminShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Traits\GeneralTrait;

    public function index()
    {
        try {
            $data = Admin_shifts::Selection()->with('treasury','admin')->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);
            $is_finished = Admin_shifts::selection()->where(['admin_id'=>auth()->user()->id,'is_finished'=>1])->first();

            return view('admin.admin_shifts.index', compact('data','is_finished'));
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
        try {
            $treasuries = Admin_treasuries::selectionActive()->where('admin_id',auth()->user()->id)->with('treasury')->get();
            $treasuries = $this->added_byAndUpdated_by_array($treasuries);
             
            $admin_shift = Admin_shifts::selection()->where(['admin_id'=>auth()->user()->id,'is_finished'=>1])->get();
            if(!empty($admin_shift) and count($admin_shift) != 0){
                session()->flash('error', 'يوجد شفت مفتوح الرجاء اغلاق الشفت و المحاولة مرة اخرة');

                return redirect()->back();
            }
            $admin_shift = Admin_shifts::selection()->get();
            foreach($treasuries as $treasury){
                foreach($admin_shift as $shift){
                    if($treasury->treasury_id == $shift->treasury_id and $shift->is_finished == 1 ){
                    $treasury->is_finished = 1;
                }
            }
             }
            return view('admin.admin_shifts.create', compact('treasuries'));
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
        $request->validate([
            'treasury_id' => 'required',
        ],
        [
            'treasury_id.required' =>'الرجاء اختيار الخزنة',
        ]);
        try {
            $com_code = auth()->user()->com_code;
            $admin_id = auth()->user()->id;
            $admin_shift = Admin_shifts::selection()->where(['admin_id'=>$admin_id,'is_finished'=>1])->get();
            if(!empty($admin_shift) and count($admin_shift) != 0){
                session()->flash('error', 'يوجد شفت مفتوح الرجاء اغلاق الشفت و المحاولة مرة اخرة');

                return redirect()->back();
            }
            /************ admin treasuries find */
            $treasury = Admin_treasuries::selection()->where(['admin_id'=>$admin_id,'treasury_id'=>$request->treasury_id])->first();
            if (empty($treasury)) {
                session()->flash('error', 'عفوا الخزنة غير موجودة');
    
                return redirect()->back();
            }
            //set shift code             
            $row = Admin_shifts::Selection()->first();
            if (! $row) {
                $data_insert['shift_code'] = 1;
            } else {
                $data_insert['shift_code'] = $row->shift_code + 1;
            }
            /*************** is finished treasury */
            $admin_shift = Admin_shifts::selection()->get();
                foreach($admin_shift as $shift){
                    if($request->treasury_id == $shift->treasury_id and $shift->is_finished == 1 ){
                            session()->flash('error', 'هذه الخزنة مشغولة الرجاء اختيار خزنة اخرة');
            
                            return redirect()->back();
                        }
             }
            $data_insert['admin_id'] = $admin_id;
            $data_insert['treasury_id'] = $request->treasury_id;
            $data_insert['treasury_balnce_in_shift_start'] = 0;
            $data_insert['start_date'] = date('Y-m-d H:i:s');
            $data_insert['is_finished'] = 1;
            $data_insert['treasury_balnce_in_shift_start'] = 0;
            $data_insert['added_by'] = $admin_id;
            $data_insert['date'] = date('Y-m-d');
            $data_insert['com_code'] = $com_code;
            Admin_shifts::create($data_insert);
            session()->flash('success', 'تم اضافة الحزنة للشفت بنجاح');
    
            return redirect()->route('admin_shifts.index');
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
