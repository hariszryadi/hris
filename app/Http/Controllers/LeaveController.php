<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCategoryLeave;
use App\Models\MsTypeLeave;
use App\Models\TrLeave;
use Carbon\Carbon;
use DataTables;
use Auth;
use DB;

class LeaveController extends Controller
{
    // '0' => 'Reject', 
    // '1' => 'Pending', 
    // '2' => 'Approved', 
    // '3' => 'Cancelled', 
    
    protected $_view = 'frontend.leave';

    public function index()
    {
        $typeLeave = MsTypeLeave::get();
        $empl_id = Auth::guard('user')->user()->empl_id;
        $countApproval = DB::table('tr_leave')->where('empl_id', $empl_id)->where('status', 2)->count();
        $countRejected = DB::table('tr_leave')->where('empl_id', $empl_id)->where('status', 0)->count();
        return view($this->_view)->with(compact('typeLeave', 'countApproval', 'countRejected'));
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

    public function getStatusRequestLeave(Request $request)
    {
        $empl_id = Auth::guard('user')->user()->empl_id;
        return Datatables::of(TrLeave::where('empl_id', $empl_id)->orderBy('id', 'desc')->get())
                ->addColumn('detail_leave', function($data){
                    return '<div class="row">
                        <div class="col-4">
                            <span class="detail-leave">Tanggal Mulai</span>
                        </div>
                        <div class="col-6">
                            : '.$data->start_date.'
                        </div>
                        <div class="col-2">
                            '.$this->badgeTypeLeave($data->type_leave_id).'
                        </div>
                        <div class="col-4">
                            <span class="detail-leave">Tanggal Selesai</span>
                        </div>
                        <div class="col-6">
                            : '.$data->end_date.'
                        </div>
                        <div class="col-4">
                            <strong>Deskripsi</strong>
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
                ->rawColumns(['detail_leave', 'action'])
                ->make(true);
    }

    public function cancelRequestLeave(Request $request)
    {
        $leave = TrLeave::where('id', $request->id);
        $leave->update(['status' => 3]);
    }

    public function badgeTypeLeave($data)
    {
        if ($data == 1) {
            return '<span class="badge-cuti">Cuti</span>';
        } else {
            return '<span class="badge-izin">Izin</span>';
        }
    }
}
