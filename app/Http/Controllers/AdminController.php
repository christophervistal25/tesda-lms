<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function logout()
    {
    	auth('admin')->logout();
    	return redirect(route('admin.dashboard'));
    }
}
