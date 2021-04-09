<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCategoryLeave;
use App\Models\MsTypeLeave;
use App\Models\TrLeave;
use Carbon\Carbon;
use Auth;
use DB;

class LeaveController extends Controller
{
    protected $_view = 'frontend.leave';

    public function isNull($data){
        return (($data != null) ? trim($data) : "-");
    }

    public function index()
    {
        $typeLeave = MsTypeLeave::get();
        return view($this->_view)->with(compact('typeLeave'));
    }

    public function getCategoryLeave(Request $request)
    {
        $categoryLeave = MsCategoryLeave::where('type_leave_id', $request->id)->get();
        return response()->json($categoryLeave);
    }

    public function getLeave(Request $request)
    {
        $typeLeave = $request->type_leave;
        $categoryLeave = $request->category_leave;
        $startDate = $request->start_date;
        $data = [
            'type_leave' => $typeLeave,
            'category_leave' => $categoryLeave,
            'start_date' => $startDate
        ];
        return response()->json($data);
    }

    public function postLeave(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $typeLeaveId = $request->type_leave;
        $categoryLeaveId = $request->category_leave;
        $description = $this->isNull($request->description);
        $empl_id = Auth::guard('user')->user()->empl_id;

        try {
            $query = DB::table('tr_leave')
                    ->where('empl_id', $empl_id)
                    ->where('status', 1)->count();

            if ($query) {
                return response()->json([
                    'message' => 'Anda telah mengajukan cuti/izin sebelumnya. Lakukan cancel request terlebih dahulu'
                ], 400);
            }

            $trLeave = TrLeave::create([
                'start_date' => $startDate,
                'end_date' => $endDate,
                'type_leave_id' => $typeLeaveId,
                'category_leave_id' => $categoryLeaveId,
                'status' => 1,
                'description' => $description,
                'empl_id' => $empl_id
            ]);
            $trLeave->update(['tr_leave_id' => \sprintf("LV-".Carbon::now()->format('Ymd')."%04d", $trLeave->id)]);

            return response()->json([
                'message' => 'Berhasil melakukan submit form cuti',
                'data' => $trLeave
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal melakukan submit form cuti',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
