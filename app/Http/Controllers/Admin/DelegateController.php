<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delegate;
use App\Traits;
use Illuminate\Http\Request;

class DelegateController extends Controller
{
    use Traits\GeneralTrait;
    public function index()
    {
        try {
            $data = Delegate::Selection()->with(['parentAccuont', 'accuont'])->paginate(PAGINATION_COUNT);
            $data = $this->added_byAndUpdated_by_array($data);

            return view('admin.delegates.index', compact('data'));
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            return view('admin.delegates.create');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما' . ' => ' . $ex->getMessage());

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
