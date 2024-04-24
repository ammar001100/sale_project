<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TreasuryDeliveryRequest;
use App\Http\Requests\TreasuryRequest;
use App\Models\Treasuries_delivery;
use App\Models\Treasury;
use App\Traits;
use Illuminate\Http\Request;

class TreasuryController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        $data = $this->get_cols_where(new Treasury, 'id', 'DESC', PAGINATION_COUNT);

        return view('admin.treasuries.index', compact('data'));
    }

    public function create()
    {
        return view('admin.treasuries.create');
    }

    public function store(TreasuryRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            // التاكد من موجود خزنه نفس الاسم
            $checkExists = Treasury::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {
                // التاكد من وجود جزنه رئيسية
                if ($request->is_master == 1) {
                    $checkExists_is_master = Treasury::where(['is_master' => 1, 'com_code' => $com_code])->first();
                    if ($checkExists_is_master != null) {
                        session()->flash('error', 'توجد خزنة رئيسية بالفعل');

                        return redirect()->route('admin.treasuries.create')->withInput();
                    }
                }
                $data['name'] = $request->name;
                $data['is_master'] = $request->is_master;
                $data['last_isal_exhcange'] = $request->last_isal_exhcange;
                $data['last_isal_collect'] = $request->last_isal_collect;
                $data['active'] = $request->active;
                $data['com_code'] = $com_code;
                $data['added_by'] = auth()->user()->id;
                $data['date'] = date('Y-m-d');
                Treasury::create($data);
                session()->flash('success', 'تم اضافة الخزنة بنجاح');

                return redirect()->route('admin.treasuries');
            } else {
                session()->flash('error', 'اسم الخزنة موجود بالفعل');

                return redirect()->route('admin.treasuries.create')->withInput();
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function show(string $id)
    {
        try {
            $data = Treasury::selection()->find($id);
            $data = $this->added_byAndUpdated_by($data);
            if (empty($data)) {
                session()->flash('error', 'عفوا الخزنة غير موجودة');

                return redirect()->back();
            }
            $treasuries_delivery = Treasuries_delivery::selection()->where(['treasuries_id' => $id])->get();
            if (! empty($treasuries_delivery)) {
                foreach ($treasuries_delivery as $info) {
                    $info->name = Treasury::where(['id' => $info->treasuries_can_delivery_id])->value('name');
                }
            }

            return view('admin.treasuries.show', compact('data', 'treasuries_delivery'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function edit(string $id)
    {
        $data = Treasury::selection()->find($id);
        if ($data == null) {
            session()->flash('error', 'عفوا الخزنة غير موجوده');

            return redirect()->back();
        } else {
            return view('admin.treasuries.edit', compact('data'));
        }
    }

    public function update(TreasuryRequest $request, string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Treasury::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الخزنة غير موجودة');

                return redirect()->back()->withInput();
            }
            $checkExists = Treasury::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم الخزنة موجود بالفعل');

                return redirect()->back()->withInput();
            }
            // التاكد من وجود جزنه رئيسية
            if ($request->is_master == 1) {
                $checkExists_is_master = Treasury::where(['is_master' => 1, 'com_code' => $com_code])->where('id', '!=', $id)->first();
                if ($checkExists_is_master != null) {
                    session()->flash('error', 'توجد خزنة رئيسية بالفعل');

                    return redirect()->back()->withInput();
                }
            }
            $data_to_update['name'] = $request->name;
            $data_to_update['is_master'] = $request->is_master;
            $data_to_update['last_isal_exhcange'] = $request->last_isal_exhcange;
            $data_to_update['last_isal_collect'] = $request->last_isal_collect;
            $data_to_update['active'] = $request->active;
            $data_to_update['com_code'] = $com_code;
            $data_to_update['updated_by'] = auth()->user()->id;
            $data_to_update['date'] = date('Y-m-d');
            Treasury::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            session()->flash('success', 'تم تحديث بيانات الخزنة بنجاح');

            return redirect()->route('admin.treasuries');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {
            $search_by_text = $request->search_by_text;
            $data = Treasury::selection()->where('name', 'LIKE', "%{$search_by_text}%")
                ->orderBy('id', 'DESC')
                ->paginate(PAGINATION_COUNT);

            return view('admin.treasuries.ajax_search', compact('data'));
        }
    }

    public function add_treasuries_delivery($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Treasury::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الخزنة غير موجودة');

                return redirect()->back()->withInput();
            }
            $treasuries = Treasury::select('id', 'name')->where(['com_code' => $com_code, 'active' => 1])->get();

            return view('admin.treasuries.add_treasuries_delivery', compact('data', 'treasuries'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function store_treasuries_delivery(TreasuryDeliveryRequest $request, $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Treasury::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الخزنة غير موجودة');

                return redirect()->back()->withInput();
            }
            $checkExists = Treasuries_delivery::where(['treasuries_id' => $id, 'treasuries_can_delivery_id' => $request->treasuries_can_delivery_id])->first();
            if ($checkExists != null) {
                // التاكد من عدم تكرار الخزنة
                session()->flash('error', 'الخزنة موجودة بالفعل');

                return redirect()->route('admin.treasuries.add_treasuries_delivery', $id)->withInput();
            }
            $data_details['treasuries_can_delivery_id'] = $request->treasuries_can_delivery_id;
            $data_details['treasuries_id'] = $id;
            $data_details['added_by'] = auth()->user()->id;
            $data_details['com_code'] = $com_code;
            Treasuries_delivery::create($data_details);
            session()->flash('success', 'تم اضافة الخزنة بنجاح');

            return redirect()->route('admin.treasuries.show', $data->id);
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function delete_treasuries_delivery($id)
    {
        try {
            $data = Treasuries_delivery::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الخزنة غير موجودة');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف الخزنة بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
