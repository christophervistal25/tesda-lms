<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }




    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                'first_name' => ['required', 'string', 'max:255'],
                'surname'    => ['required', 'string', 'max:255'],
                'username'   => ['required', 'string', 'max:255', 'unique:users'],
                'email'      => ['required', 'string', 'email', 'max:255', 'unique:users', 'same:confirm_email'],
                'password'   => [
                    'required',
                    'string',
                    'min:8',
                    'max:16',
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
                'city_town'  => ['required', 'string'],
                'country'    => ['required', 'string', 'in:' . implode(',', array_keys(config('country.list')))],
        ]);
    }
    
 

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'name'      => $data['first_name'] . ' ' . $data['surname'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'firstname' => $data['first_name'],
            'surname'   => $data['surname'],
            'city_town' => $data['city_town'],
            'country'   => $data['country'],
        ]);
    }
}
