<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    protected $guard = 'admin';
    protected $redirectTo ='/admin';
    protected function guard()
    {
        return Auth::guard($this->guard);
    }
    public function login(){
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');;
        }
        return view('admin.auth.login');
    }
    public function getLogin(LoginRequest $request){
        if($this->guard('admin')->attempt([
            'name' => $request->name ,
            'password' => $request->password
       ])){
        session()->flash('success','تم تسجيل الدخول');
        return redirect()->route('dashboard');
       };
       session()->flash('error','عفوا البيانات غير صحيحة');
       return Redirect::back();
   }
    public function logout(){
        auth()->logout();
        return redirect()->route('admin.login');
   }
}
