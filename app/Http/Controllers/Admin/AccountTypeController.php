<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account_Type;

class AccountTypeController extends Controller
{
    public function index()
    {
        $data = Account_Type::selection()->get();

        return view('admin.account_types.index', compact('data'));
    }
}
