<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesMatrialTypeRequest;
use App\Models\Sales_matrial_type;
use App\Traits;

class SalesMatrialTypeController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        $data = $this->get_cols_where(new Sales_matrial_type, 'id', 'DESC', PAGINATION_COUNT);

        return view('admin.sales_matrial_types.index', compact('data'));
    }

    public function create()
    {
        return view('admin.sales_matrial_types.create');
    }

    public function store(SalesMatrialTypeRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            // التاكد من موجود نفس الاسم
            $checkExists = Sales_matrial_type::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {
                $data['name'] = $request->name;
                $data['active'] = $request->active;
                $data['com_code'] = $com_code;
                $data['added_by'] = auth()->user()->id;
                $data['date'] = date('Y-m-d');
                Sales_matrial_type::create($data);
                session()->flash('success', 'تم اضافة الفئة بنجاح');

                return redirect()->route('admin.sales_matrial_types');
            } else {
                session()->flash('error', 'اسم الفئة موجود بالفعل');

                return redirect()->route('admin.sales_matrial_types.create')->withInput();
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function edit(string $id)
    {
        $data = Sales_matrial_type::selection()->find($id);
        if ($data == null) {
            session()->flash('error', 'عفوا الفئة غير موجوده');

            return redirect()->back();
        } else {
            return view('admin.sales_matrial_types.edit', compact('data'));
        }
    }

    public function update(SalesMatrialTypeRequest $request, string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Sales_matrial_type::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الفئة غير موجودة');

                return redirect()->back()->withInput();
            }
            $checkExists = Sales_matrial_type::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم الفئة موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_to_update['name'] = $request->name;
            $data_to_update['active'] = $request->active;
            $data_to_update['com_code'] = $com_code;
            $data_to_update['updated_by'] = auth()->user()->id;
            Sales_matrial_type::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            session()->flash('success', 'تم تحديث بيانات الفئة بنجاح');

            return redirect()->route('admin.sales_matrial_types');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Sales_matrial_type::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الفئة غير موجودة');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف الفئة بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }
}
