<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierCategoryRequest;
use App\Models\Supplier_category;
use App\Traits;

class SupplierCategoryController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        try {
            $data = Supplier_category::Selection()->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);

            return view('admin.supplier_categories.index', compact('data'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function create()
    {
        return view('admin.supplier_categories.create');
    }

    public function store(SupplierCategoryRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            // التاكد من موجود نفس الاسم
            $checkExists = Supplier_category::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if (! $checkExists) {
                $data['name'] = $request->name;
                $data['active'] = $request->active;
                $data['com_code'] = $com_code;
                $data['added_by'] = auth()->user()->id;
                $data['date'] = date('Y-m-d');
                Supplier_category::create($data);
                session()->flash('success', 'تم اضافة فئة الموردين بنجاح');

                return redirect()->route('supplier_categories.index');
            } else {
                session()->flash('error', 'اسم فئة الموردين موجود بالفعل');

                return redirect()->route('supplier_categories.create')->withInput();
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data = Supplier_category::selection()->find($id);
        if ($data == null) {
            session()->flash('error', 'عفوا فئة الموردين غير موجوده');

            return redirect()->back();
        } else {
            return view('admin.supplier_categories.edit', compact('data'));
        }
    }

    public function update(SupplierCategoryRequest $request, string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Supplier_category::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا فئة الموردين غير موجودة');

                return redirect()->back()->withInput();
            }
            $checkExists = Supplier_category::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم فئة الموردين موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_to_update['name'] = $request->name;
            $data_to_update['active'] = $request->active;
            $data_to_update['com_code'] = $com_code;
            $data_to_update['updated_by'] = auth()->user()->id;
            Supplier_category::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            session()->flash('success', 'تم تحديث بيانات فئة الموردين بنجاح');

            return redirect()->route('supplier_categories.index');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Supplier_category::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا فئة الموردين غير موجودة');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف فئة الموردين بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }
}
