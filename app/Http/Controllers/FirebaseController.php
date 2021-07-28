<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
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

    public function destroyNotification(Request $request)
    {
        $notif = Notification::where('id', $request->id);
        $notif->update([
            'read' => true,
            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return response()->json(['success' => 'Delete Noification Successfully']);
    }
}
