<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrOvertime;
use Carbon\Carbon;
use Auth;
use DB;

class OvertimeController extends Controller
{
    // '0' => 'Reject', 
    // '1' => 'Pending', 
    // '2' => 'Approved', 
    // '3' => 'Cancelled', 

    protected $_view = 'frontend.overtime';

    public function index()
    {
        return view($this->_view);
    }

    public function postOvertime(Request $request)
    {
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $duration = $request->duration;
        $description = $this->isNull($request->description);
        $empl_id = Auth::guard('user')->user()->empl_id;

        try {
            $query = DB::table('tr_overtime')
                    ->where('empl_id', $empl_id)
                    ->where('status', 1)->count();

            if ($query) {
                return response()->json([
                    'message' => 'Anda telah mengajukan lembur sebelumnya. Lakukan cancel request terlebih dahulu'
                ], 400);
            }

            $trOvertime = TrOvertime::create([
                'start_time' => $startTime,
                'end_time' => $endTime,
                'duration' => $duration,
                'status' => 1,
                'description' => $description,
                'empl_id' => $empl_id
            ]);
            $trOvertime->update(['tr_overtime_id' => \sprintf("OT-".Carbon::now()->format('Ymd')."%04d", $trOvertime->id)]);

            return response()->json([
                'message' => 'Berhasil melakukan submit form lembur',
                'data' => $trOvertime
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal melakukan submit form lembur',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
