<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function edit()
    {
    	$admin = Auth::user();
    	return view('admin.profile.index', compact('admin'));
    }

    public function update(Request $request)
    {
    	
    	$admin = Auth::user();

    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|unique:admins,email,' . $admin->id,
    	]);

		$admin->name     = $request->name;
		$admin->email    = $request->email;
		$admin->password = is_null($request->password) ? $admin->password : bcrypt($request->password);
		$admin->save();

    	return back()->with('success', 'Successfully update your credentials.');
    }
}
