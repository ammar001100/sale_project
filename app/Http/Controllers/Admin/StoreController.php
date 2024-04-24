<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Models\Store;
use App\Traits;

class StoreController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        $data = $this->get_cols_where(new Store, 'id', 'DESC', PAGINATION_COUNT);

        return view('admin.stores.index', compact('data'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(StoreRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            // التاكد من موجود مخزن نفس الاسم
            $checkExists = Store::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {
                $data['name'] = $request->name;
                $data['phones'] = $request->phones;
                $data['address'] = $request->address;
                $data['active'] = $request->active;
                $data['com_code'] = $com_code;
                $data['added_by'] = auth()->user()->id;
                $data['date'] = date('Y-m-d');
                Store::create($data);
                session()->flash('success', 'تم اضافة المخزن بنجاح');

                return redirect()->route('admin.stores');
            } else {
                session()->flash('error', 'اسم المخزن موجود بالفعل');

                return redirect()->route('admin.stores.create')->withInput();
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function edit(string $id)
    {
        $data = Store::selection()->find($id);
        if ($data == null) {
            session()->flash('error', 'عفوا المخزن غير موجود');

            return redirect()->back();
        } else {
            return view('admin.stores.edit', compact('data'));
        }
    }

    public function update(StoreRequest $request, string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Store::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا المخزن غير موجود');

                return redirect()->back()->withInput();
            }
            $checkExists = Store::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم المخزن موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_to_update['name'] = $request->name;
            $data_to_update['phones'] = $request->phones;
            $data_to_update['address'] = $request->address;
            $data_to_update['active'] = $request->active;
            $data_to_update['com_code'] = $com_code;
            $data_to_update['updated_by'] = auth()->user()->id;
            Store::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            session()->flash('success', 'تم تحديث بيانات المخزن بنجاح');

            return redirect()->route('admin.stores');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Store::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا المخزن غير موجود');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف المخزن بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }
}
