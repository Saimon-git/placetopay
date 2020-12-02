<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SPAController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Administrator|Administrator');
    }

    public function index(Request $request)
    {
        $super_admin = $request->user()->isSuperAdmin();
        //dd($super_admin);

        return view('spa', compact('super_admin'));
    }
}
