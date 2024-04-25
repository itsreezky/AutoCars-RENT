<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

use App\Models\Users;

use Illuminate\Support\Facades\Auth;

use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller


// CREATED WITH ❤︎ Reezky
// http://itsreezky.my.id



// Auth Controller for Login and Register

{
    public function login() // Page Login
    {
        return view('Auth/login');
    }

    public function register()  // Page Register
    {
        return view('Auth/register');
    }

    public function verified()  // Page Register
    {
        return view('Auth/verified');
    }

    public function logout()  // Page Register
    {

        auth()->logout();
        Session()->flush();

        toast('Successfully Logout, Thanks for visiting.','success','top-end')->autoClose(7000);
        return view('Auth/logout');
    }


    public function authenticate(Request $request) //Auth Login
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            toast('Successfully Login, Happy RENT !','success','top-end')->autoClose(7000);
            return redirect()->intended('profile');
        }

        toast('ERROR ! Please check your credential','error','top-end')->autoClose(5000);
        return back();
    }

    public function store(Request $request){ //Register Function

        $request->validate([
        'nama' => 'required',
        'email' => 'required|unique:users,email',
        'password' => 'required',
        'confirm-password' => 'required|same:password',
    ]);

    $data = $request->except('confirm-password', 'password',);
    $data['password'] = Hash::make($request->password);

    Users::create($data);

    toast('Account Created Successfully, You Can Login Now','success','top-end')->autoClose(7000);
    return redirect('login');
}

}
