<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('frontend.login');
    }

    public function credentials(Request $request)
    {
        $this->validate($request, [
            'nip' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::guard('user')->attempt(['nip' => $request->nip, 'password' => $request->password])) {
            return redirect()->back()->withErrors(['error' => 'NIP/Password yang Anda Masukkan Salah']);
        }

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Auth::guard('user')->logout();

        return redirect('/login');
    }
}
