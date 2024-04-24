<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralSettingRequest;
use App\Models\General_setting;
use App\Traits;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    use Traits\GeneralTrait;

    public function index()
    {
        $data = auth()->user()->generalSetting;
        if (! empty($data)) {
            if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
                $data['updated_by_admin'] = $data->admin->name;
            }
        }

        return view('admin.setting.general.index', compact('data'));
    }

    public function edit()
    {
        $data = General_setting::where('com_code', auth()->user()->com_code)->first();

        return view('admin.setting.general.edit', compact('data'));
    }

    public function update(GeneralSettingRequest $request)
    {
        $admin_general_setting = auth()->user()->generalSetting;
        //return dd($request);
        try {
            if ($request->has('photo')) {
                //validate image
                $request->validate([
                    'photo' => 'required | mimes:png,jpg,jpeg | max:2000',
                ]);
                //save image by Traits
                $image_path = $this->saveImage($request->photo, 'admin_sttings_imgs');
                if ($admin_general_setting->photo != 'default.png') {
                    Storage::disk('admin_sttings_imgs')->delete($admin_general_setting->photo);
                }
                $admin_general_setting->photo = $image_path;
            }
            $admin_general_setting = auth()->user()->generalSetting;
            $admin_general_setting->system_name = $request->system_name;
            $admin_general_setting->address = $request->address;
            $admin_general_setting->phone = $request->phone;
            $admin_general_setting->general_alert = $request->general_alert;
            $admin_general_setting->updated_by = auth()->user()->id;
            $admin_general_setting->save();
            session()->flash('success', 'تم التعديل بنجاح');

            return redirect()->route('admin.setting.general');
        } catch (\Exception $ex) {
            session()->flash('error', 'حدث خطاء ما'.' => '.$ex->getMessage());

            return redirect()->back();
        }
    }
}
