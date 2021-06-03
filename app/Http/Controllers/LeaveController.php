<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCategoryLeave;
use App\Models\TrLeaveQuota;
use App\Models\MsTypeLeave;
use App\Models\MsEmployee;
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
            $query = DB::table('tr_leave_quota')
                    ->where('empl_id', $empl_id)
                    ->where('max_quota', 0)->count();

            if ($query) {
                return response()->json([
                    'message' => 'Maaf Anda tidak memiliki kuota cuti'
                ], 400);
            }

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
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col-lg-4"><span class="detail-leave">Tanggal Mulai</span></div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-7">'.$this->dateFormat($data->start_date).'</div>
                                        <div class="col-lg-4"><span class="detail-leave">Tanggal Selesai</span></div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-7">'.$this->dateFormat($data->end_date).'</div>
                                        <div class="col-lg-4"><strong>Deskripsi</strong></div>
                                        <div class="col-lg-1">:</div>
                                        <div class="col-lg-7">'.$data->description.'</div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    '.$this->badgeTypeLeave($data->type_leave_id).'
                                </div>
                            </div>';
                })
                ->addColumn('action', function($data){
                    if ($data->status == 1) {
                        return '<span data-leave-id="'.$data->id.'" data-status="3" class="update-status text-secondary cancel-request">Cancel</span>';
                    }
                })
                ->rawColumns(['detail_leave', 'action'])
                ->make(true);
    }

    public function getEmplRequestLeave(Request $request)
    {
        $empl_id = Auth::guard('user')->user()->empl_id;
        $division_id = MsEmployee::where('id', $empl_id)->pluck('division_id');
        $query = TrLeave::select(
                    'tr_leave.id as leave_id',
                    'tr_leave.tr_leave_id',
                    'tr_leave.start_date',
                    'tr_leave.end_date',
                    'tr_leave.type_leave_id',
                    'tr_leave.category_leave_id',
                    'tr_leave.description',
                    'tr_leave.status',
                    'ms_empl.id as empl_id',
                    'ms_empl.nip',
                    'ms_empl.empl_name',
                    'ms_empl.division_id',
                    'ms_empl.gender',
                    'ms_empl.avatar'
                )
                ->join('ms_empl', 'tr_leave.empl_id', '=', 'ms_empl.id')
                ->where('ms_empl.division_id', $division_id)
                ->orderBy('tr_leave.id', 'desc')
                ->get();

        return Datatables::of($query)
                ->addColumn('detail_leave', function($data){
                    $avatar = asset('storage/'.$data->avatar);
                    if ($data->gender == 'Pria') {
                        $onerror = asset('assets/admin/images/male.png');
                    } else {
                        $onerror = asset('assets/admin/images/female.png');
                    }
                    return '<div class="row">
                                <div class="col-lg-3">
                                    <img class="image-datatables" src="'.$avatar.'" onerror="this.src=\''.$onerror.'\'">
                                </div>
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-lg-4 no-padding"><strong>Nama</strong></div>
                                        <div class="col-lg-1 no-padding">:</div>
                                        <div class="col-lg-7 no-padding">'.$data->empl_name.'</div>
                                        <div class="col-lg-4 no-padding"><strong>NIP</strong></div>
                                        <div class="col-lg-1 no-padding">:</div>
                                        <div class="col-lg-7 no-padding">'.$data->nip.'</div>
                                        <div class="col-lg-4 no-padding"><span class="detail-leave">Tanggal Mulai</span></div>
                                        <div class="col-lg-1 no-padding">:</div>
                                        <div class="col-lg-7 no-padding">'.$this->dateFormat($data->start_date).'</div>
                                        <div class="col-lg-4 no-padding"><span class="detail-leave">Tanggal Selesai</span></div>
                                        <div class="col-lg-1 no-padding">:</div>
                                        <div class="col-lg-7 no-padding">'.$this->dateFormat($data->end_date).'</div>
                                        <div class="col-lg-4 no-padding"><strong>Deskripsi</strong></div>
                                        <div class="col-lg-1 no-padding">:</div>
                                        <div class="col-lg-7 no-padding">'.$data->description.'</div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    '.$this->badgeTypeLeave($data->type_leave_id).'
                                </div>
                            </div>';
                })
                ->addColumn('action', function($data){
                    if ($data->status == 1 ) {
                        return '<span data-leave-id="'.$data->leave_id.'" data-empl-id="'.$data->empl_id.'" data-status="2" class="update-status text-success approve-request">Approve</span><hr>
                            <span data-leave-id="'.$data->leave_id.'" data-empl-id="'.$data->empl_id.'" data-status="0" class="update-status text-danger reject-request">Reject</span>';
                    }
                })
                ->rawColumns(['detail_leave', 'action'])
                ->make(true);
    }

    public function updateStatusRequestLeave(Request $request)
    {
        $leave = TrLeave::where('id', $request->leaveId);
        if ($request->status == 2) {
            $leave->update(['status' => $request->status]);
            $leaveQuota = TrLeaveQuota::where('empl_id', $request->emplId);
            $leaveQuota->increment('used_quota');
            $leaveQuota->decrement('max_quota');
        } else {
            $leave->update(['status' => $request->status]);
        }

        return response()->json(['success' => 'Update Status Successfully']);
    }

    private function badgeTypeLeave($typeLeave)
    {
        if ($typeLeave == 1) {
            return '<span class="badge-cuti">Cuti</span>';
        } else {
            return '<span class="badge-izin">Izin</span>';
        }
    }

    private function dateFormat($date)
    {
        $oldDate = $date;
        $arr = explode('-', $oldDate);
        $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
        return $newDate;
    }
}
