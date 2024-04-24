<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemcardCategoryRequest;
use App\Models\Itemcard_category;
use App\Traits;

class ItemcardCategoryController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        $data = $this->get_cols_where(new Itemcard_category, 'id', 'DESC', PAGINATION_COUNT);

        return view('admin.itemcard_categories.index', compact('data'));
    }

    public function create()
    {
        return view('admin.itemcard_categories.create');
    }

    public function store(ItemcardCategoryRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            // التاكد من موجود الاسم
            $checkExists = Itemcard_category::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {
                $data['name'] = $request->name;
                $data['active'] = $request->active;
                $data['com_code'] = $com_code;
                $data['added_by'] = auth()->user()->id;
                $data['date'] = date('Y-m-d');
                Itemcard_category::create($data);
                session()->flash('success', 'تم اضافة الفئة الصنف بنجاح');

                return redirect()->route('itemcard_categories.index');
            } else {
                session()->flash('error', 'اسم الفئة الصنف موجود بالفعل');

                return redirect()->route('itemcard_categories.create')->withInput();
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
        $data = Itemcard_category::selection()->find($id);
        if ($data == null) {
            session()->flash('error', 'عفوا فئة الصنف غير موجوده');

            return redirect()->back();
        } else {
            return view('admin.itemcard_categories.edit', compact('data'));
        }
    }

    public function update(ItemcardCategoryRequest $request, string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Itemcard_category::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الفئة الاصناف غير موجودة');

                return redirect()->back()->withInput();
            }
            $checkExists = Itemcard_category::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم الفئة الاصناف موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_to_update['name'] = $request->name;
            $data_to_update['active'] = $request->active;
            $data_to_update['com_code'] = $com_code;
            $data_to_update['updated_by'] = auth()->user()->id;
            Itemcard_category::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            session()->flash('success', 'تم تحديث بيانات فئة الاصناف بنجاح');

            return redirect()->route('itemcard_categories.index');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Itemcard_category::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا فئة الاصناف غير موجودة');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف فية الاصناف بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }
}
