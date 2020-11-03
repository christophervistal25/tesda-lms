<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User as Student, Course, Module, Activity, Admin};
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AdminController extends Controller
{
    public function index()
    {
        $start = Carbon::now()->firstOfYear();
        $end   = Carbon::now()->endOfYear();

        $period = CarbonPeriod::create($start->format('Y-m-d H:i:s'), '1 month', $end->format('Y-m-d H:i:s'));
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $studentRegisteredByMonth = [];
        foreach ($period as $dt) {
            $start = Carbon::parse($dt->format("Y-m-d"))->format('Y-m-d H:i:s');
            $end   = Carbon::parse($start)->endOfMonth()->format('Y-m-d H:i:s');
            $studentRegisteredByMonth[Carbon::parse($dt)->month] = Student::whereBetween('created_at', [$start, $end])
                                                                            ->count();
        }

        $students   = Student::count();
        $course     = Course::count();
        $modules    = Module::count();
        $activities = Activity::count();
        $admins     = Admin::get();
        
        return view('admin', compact('students', 'course', 'modules', 'activities', 'admins', 'studentRegisteredByMonth'));
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
