<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UomRequest;
use App\Models\Uom;
use App\Traits;
use Illuminate\Http\Request;

class UomController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        $data = $this->get_cols_where(new Uom, 'id', 'DESC', PAGINATION_COUNT);

        return view('admin.uoms.index', compact('data'));
    }

    public function create()
    {
        return view('admin.uoms.create');
    }

    public function store(UomRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            // التاكد من موجود وحدة نفس الاسم
            $checkExists = Uom::where(['name' => $request->name, 'com_code' => $com_code])->first();
            if ($checkExists == null) {
                $data['name'] = $request->name;
                $data['is_master'] = $request->is_master;
                $data['active'] = $request->active;
                $data['com_code'] = $com_code;
                $data['added_by'] = auth()->user()->id;
                $data['date'] = date('Y-m-d');
                Uom::create($data);
                session()->flash('success', 'تم اضافة الوحدة بنجاح');

                return redirect()->route('admin.uoms');
            } else {
                session()->flash('error', 'اسم الوحدة موجود بالفعل');

                return redirect()->route('admin.uoms.create')->withInput();
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function edit(string $id)
    {
        $data = Uom::selection()->find($id);
        if ($data == null) {
            session()->flash('error', 'عفوا الوحدة غير موجود');

            return redirect()->back();
        } else {
            return view('admin.uoms.edit', compact('data'));
        }
    }

    public function update(UomRequest $request, string $id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = Uom::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الوحدة غير موجود');

                return redirect()->back()->withInput();
            }
            $checkExists = Uom::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
            if ($checkExists != null) {
                session()->flash('error', 'اسم الوحدة موجود بالفعل');

                return redirect()->back()->withInput();
            }
            $data_to_update['name'] = $request->name;
            $data_to_update['is_master'] = $request->is_master;
            $data_to_update['active'] = $request->active;
            $data_to_update['com_code'] = $com_code;
            $data_to_update['updated_by'] = auth()->user()->id;
            Uom::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
            session()->flash('success', 'تم تحديث بيانات الوحدة بنجاح');

            return redirect()->route('admin.uoms');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }

    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {
            $search_by_text = $request->search_by_text;
            $is_master_search = $request->is_master_search;
            if ($search_by_text == '') {
                $field1 = 'id';
                $operator1 = '>';
                $value1 = '0';
            } else {
                $field1 = 'name';
                $operator1 = 'LIKE';
                $value1 = "%{$search_by_text}%";
            }
            if ($is_master_search == 'all') {
                $field2 = 'id';
                $operator2 = '>';
                $value2 = '0';
            } else {
                $field2 = 'is_master';
                $operator2 = '=';
                $value2 = $is_master_search;
            }
            $data = Uom::selection()->where($field1, $operator1, $value1)
                ->where($field2, $operator2, $value2)
                ->orderBy('id', 'DESC')
                ->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);

            return view('admin.uoms.ajax_search', compact('data'));
        }
    }

    public function destroy(string $id)
    {
        try {
            $data = Uom::selection()->find($id);
            if (empty($data)) {
                session()->flash('error', 'عفوا الوحدة غير موجود');

                return redirect()->back()->withInput();
            }
            $data->delete();
            session()->flash('success', 'تم حذف الوحدة بنجاح');

            return redirect()->back();
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }
}
