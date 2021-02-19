<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('backend.login');
    }

    public function credentials(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->back()->withErrors(['error' => 'Email/Password yang Anda Masukkan Salah']);
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.dashboard');;
    }
}
