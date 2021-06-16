<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('backend.change-password');
    }

    public function update(Request $request)
    {
        $oldPassword = $request->old_password;
        $newPassword = $request->new_password;

        $query = Admin::where('id', $request->id)->first();
        if (Hash::check($oldPassword, $query->password)) {
            $query->update([
                'password' => Hash::make($newPassword)
            ]);

            return response()->json([
                'message' => 'Berhasil mengubah password',
            ], 200);
            // return redirect()->route('admin.dashboard')->with('success', 'Success Message');
        }else{
            return response()->json([
                'message' => 'Password lama salah',
            ], 400);
            // return redirect()->route('admin.dashboard')->with('error', 'Error Message');
        }
    }
}
