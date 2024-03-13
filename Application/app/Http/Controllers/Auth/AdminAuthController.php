<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\AdminLoginRequest;

class AdminAuthController extends Controller
{


    public function loginForm()
    {
        return view('auth.admin.admin-login');
    }

    public function login(AdminLoginRequest $request)
    {
        $date = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::guard('admin')->attempt($date)) {
            $request->session()->regenerate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login');
    }


    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
