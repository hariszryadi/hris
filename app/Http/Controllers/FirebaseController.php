<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FirebaseController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function saveToken(Request $request)
    {
        Auth::guard('user')->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
}
