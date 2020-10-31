<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User as Student, Course, Module, Activity, Admin};
use Auth;

class AdminController extends Controller
{
    public function index()
    {
        $students   = Student::count();
        $course     = Course::count();
        $modules    = Module::count();
        $activities = Activity::count();
        $admins     = Admin::get();
        return view('admin', compact('students', 'course', 'modules', 'activities', 'admins'));
    }

    public function register()
    {
        return view('admin.accounts.create');
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required|min:8|max:20|confirmed',
        ]);

        Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Successfully add new administrator.');
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        $status = Admin::STATUS;
        return view('admin.accounts.edit', compact('admin', 'status'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|unique:admins,email,' . $admin->id,
            'password' => 'confirmed',
            'status'   => 'required|in:' . implode(',', Admin::STATUS)
        ]);

        $admin->name     = $request->name;
        $admin->email    = $request->email;
        $admin->password = is_null($request->password) ? $admin->password : bcrypt($request->password);
        $admin->status   = $request->status;
        $admin->save();

        if (Auth::user()->id === (int) $id && strtolower($admin->status) === 'in-active') {
            auth('admin')->logout();
            return redirect(route('admin.login'));
        }

        return back()->with('success', "Successfully update {$admin->name} credentials.");
    }

    public function logout()
    {
    	auth('admin')->logout();
    	return redirect(route('admin.dashboard'));
    }
}
