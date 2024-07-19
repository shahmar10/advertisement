<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthContoller extends Controller
{
    public function loginPage()
    {
        if (\auth()->check())
        {
            return to_route('dashboard.home');
        }

        return view('dashboard.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|max:500',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return to_route('dashboard.login')->with('fail', 'Email or password is wrong');
        }

        return to_route('dashboard.home')->with('success', 'Log in successfully');
    }

    public function logout()
    {
        \auth()->logout();

        return to_route('dashboard.login');
    }
}
