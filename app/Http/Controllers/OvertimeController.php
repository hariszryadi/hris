<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrOvertime;
use Carbon\Carbon;
use DataTables;
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

    public function getStatusRequestOvertime(Request $request)
    {
        $empl_id = Auth::guard('user')->user()->empl_id;
        return Datatables::of(TrOvertime::where('empl_id', $empl_id)->orderBy('id', 'desc')->get())
                ->addColumn('detail_overtime', function($data){
                    return '<div class="row">
                        <div class="col-4">
                            <span class="detail-overtime">Waktu Mulai</span>
                        </div>
                        <div class="col-6">
                            : '.$data->start_time.'
                        </div>
                        <div class="col-4">
                            <span class="detail-overtime">Waktu Akhir</span>
                        </div>
                        <div class="col-6">
                            : '.$data->end_time.'
                        </div>
                        <div class="col-4">
                            <strong>Keterangan</strong>
                        </div>
                        <div class="col-6">
                            : '.$data->description.'
                        </div>
                    </div>';
                })
                ->addColumn('action', function($data){
                    if ($data->status == 1) {
                        return '<span data-id="'.$data->id.'" class="cancel-request">Cancel</span>';
                    }
                })
                ->rawColumns(['detail_overtime', 'action'])
                ->make(true);
    }

    public function cancelRequestOvertime(Request $request)
    {
        $leave = TrOvertime::where('id', $request->id);
        $leave->update(['status' => 3]);
    }
}
