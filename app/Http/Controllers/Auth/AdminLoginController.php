<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
     public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        // Validate form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'], $request->remember)) {
            return redirect()->intended(route('admin.dashboard'));
        } else {
            return redirect()->back()->withErrors(['message' => 'Please check your Email / Password'])->withInput($request->only('email','remember'));    
        }

        
    }
}
