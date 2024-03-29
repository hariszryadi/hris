<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\TrOvertimeAmount;
use App\Models\TrOvertime;
use App\Models\MsEmployee;
use App\Models\Notification;
use App\Models\User;
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
        return view($this->_view)->with(compact('countOvertime'));
    }

    public function getInfoOvertime(Request $request)
    {
        $empl_id = Auth::guard('user')->user()->empl_id;
        $query = DB::table('tr_overtime')->where('empl_id', $empl_id)->whereMonth('created_at', $request->month)->where('status', 2)->whereYear('created_at', $request->year)->sum('duration');
        if ($query) {
            $totalOvertime = $query;
        } else {
            $totalOvertime = "00:00:00";
        }

        return response()->json([
            'totalOvertime' => $totalOvertime
        ]);
    }

    public function postOvertime(Request $request)
    {
        $overtimeDate = $request->overtime_date;
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $duration = $request->duration;
        $description = $this->isNull($request->description);
        $empl_id = Auth::guard('user')->user()->empl_id;
        $division_id = MsEmployee::where('id', $empl_id)->pluck('division_id');

        try {
            $queryNotif = User::select(
                        'users.id',
                        'users.name',
                        'users.nip',
                        'users.device_token',
                        'users.device_token',
                        'ms_empl.division_id',
                        'ms_empl.avatar'
                    )
                    ->join('ms_empl', 'users.empl_id', '=', 'ms_empl.id')
                    ->where('ms_empl.division_id', $division_id)
                    ->where('ms_empl.head_division', true)
                    ->first();

            $query = DB::table('tr_overtime')
                    ->where('empl_id', $empl_id)
                    ->where('status', 1)->count();

            if ($query) {
                return response()->json([
                    'message' => 'Anda telah mengajukan lembur sebelumnya. Lakukan cancel request terlebih dahulu'
                ], 400);
            }

            $trOvertime = TrOvertime::create([
                'overtime_date' => $overtimeDate,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'duration' => $duration,
                'status' => 1,
                'description' => $description,
                'empl_id' => $empl_id
            ]);
            $trOvertime->update(['tr_overtime_id' => \sprintf("OT-".Carbon::now()->format('Ymd')."%04d", $trOvertime->id)]);

            $notification = new Notification;
            $notification->type_transaction = 2;
            $notification->transaction_id = $trOvertime->tr_overtime_id;
            $notification->user_id = $queryNotif->id;
            $notification->read = false;
            $notification->save();
            $notification->toSingleDevice($queryNotif->device_token, 'Pengajuan Lembur Baru', 'Hallo, ada pengajuan lembur baru', null, route('overtime'));

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
                            <div class="col-lg-4"><span class="detail-overtime">Tanggal Lembur</span></div>
                            <div class="col-lg-8">'.$this->dateFormat($data->overtime_date).'</div>
                            <div class="col-lg-4"><span class="detail-overtime">Waktu Mulai</span></div>
                            <div class="col-lg-8">'.$data->start_time.'</div>
                            <div class="col-lg-4"><span class="detail-overtime">Waktu Akhir</span></div>
                            <div class="col-lg-8">'.$data->end_time.'</div>
                            <div class="col-lg-4"><span class="detail-overtime">Durasi</span></div>
                            <div class="col-lg-8">'.$data->duration.'</div>
                            <div class="col-lg-4"><strong>Keterangan</strong></div>
                            <div class="col-lg-8">'.$data->description.'</div>
                        </div>';
                })
                ->editColumn('status', function($data) {
                    if ($data->status == 1) {
                        return '<span class="text-warning">Pending</span>';
                    } elseif($data->status == 2) { 
                        return '<span class="text-success">Approve</span><span class="text-updated-by">Approved By: '.$data->updatedBy->empl_name.'</span>';
                    } elseif($data->status == 3){
                        return '<span class="text-secondary">Cancelled</span>';
                    }else {
                        return '<span class="text-danger">Reject</span><span class="text-updated-by">Rejected By: '.$data->updatedBy->empl_name.'</span>';
                    }
                })
                ->addColumn('action', function($data){
                    if ($data->status == 1) {
                        return '<span data-overtime-id="'.$data->id.'" data-status="3" class="update-status text-secondary cancel-request">Cancel</span>';
                    }
                })
                ->rawColumns(['detail_overtime', 'status', 'action'])
                ->make(true);
    }

    public function getEmplRequestOvertime()
    {
        $query = '';
        $empl_id = Auth::guard('user')->user()->empl_id;
        $division_id = MsEmployee::where('id', $empl_id)->pluck('division_id');
        $dirId = MsEmployee::checkDir()->pluck('id');
        $listWadirId = MsEmployee::checkWaDir()->pluck('id');
        $collectWadirId = new Collection($listWadirId);
        $collectDirId = new Collection($dirId);

        if ($collectDirId->contains($empl_id)) {
            $query = TrOvertime::select(
                        'tr_overtime.id as overtime_id',
                        'tr_overtime.tr_overtime_id',
                        'tr_overtime.overtime_date',
                        'tr_overtime.start_time',
                        'tr_overtime.end_time',
                        'tr_overtime.duration',
                        'tr_overtime.description',
                        'tr_overtime.status',
                        'tr_overtime.updated_by',
                        'ms_empl.id as empl_id',
                        'ms_empl.nip',
                        'ms_empl.empl_name',
                        'ms_empl.division_id',
                        'ms_empl.gender',
                        'ms_empl.avatar'
                    )
                    ->join('ms_empl', 'tr_overtime.empl_id', '=', 'ms_empl.id')
                    ->orderBy('tr_overtime.id', 'desc')
                    ->get();
        } elseif($collectWadirId->contains($empl_id)){
            $query = TrOvertime::select(
                        'tr_overtime.id as overtime_id',
                        'tr_overtime.tr_overtime_id',
                        'tr_overtime.overtime_date',
                        'tr_overtime.start_time',
                        'tr_overtime.end_time',
                        'tr_overtime.duration',
                        'tr_overtime.description',
                        'tr_overtime.status',
                        'tr_overtime.updated_by',
                        'ms_empl.id as empl_id',
                        'ms_empl.nip',
                        'ms_empl.empl_name',
                        'ms_empl.division_id',
                        'ms_empl.gender',
                        'ms_empl.avatar'
                    )
                    ->join('ms_empl', 'tr_overtime.empl_id', '=', 'ms_empl.id')
                    ->where('empl_id', '!=', $empl_id)
                    ->where('ms_empl.head_division', true)
                    ->orderBy('tr_overtime.id', 'desc')
                    ->get();
        } else {
            $query = TrOvertime::select(
                        'tr_overtime.id as overtime_id',
                        'tr_overtime.tr_overtime_id',
                        'tr_overtime.overtime_date',
                        'tr_overtime.start_time',
                        'tr_overtime.end_time',
                        'tr_overtime.duration',
                        'tr_overtime.description',
                        'tr_overtime.status',
                        'tr_overtime.updated_by',
                        'ms_empl.id as empl_id',
                        'ms_empl.nip',
                        'ms_empl.empl_name',
                        'ms_empl.division_id',
                        'ms_empl.gender',
                        'ms_empl.avatar'
                    )
                    ->join('ms_empl', 'tr_overtime.empl_id', '=', 'ms_empl.id')
                    ->where('ms_empl.division_id', $division_id)
                    ->where('ms_empl.head_division', null)
                    ->orderBy('tr_overtime.id', 'desc')
                    ->get();
        }
        

        return Datatables::of($query)
            ->addColumn('detail_overtime', function($data){
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
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-4"><strong>Nama</strong></div>
                                    <div class="col-lg-8">'.$data->empl_name.'</div>
                                    <div class="col-lg-4"><strong>NIP</strong></div>
                                    <div class="col-lg-8">'.$data->nip.'</div>
                                    <div class="col-lg-4"><span class="detail-overtime">Tanggal Lembur</span></div>
                                    <div class="col-lg-8">'.$this->dateFormat($data->overtime_date).'</div>
                                    <div class="col-lg-4"><span class="detail-overtime">Waktu Mulai</span></div>
                                    <div class="col-lg-8">'.$data->start_time.'</div>
                                    <div class="col-lg-4"><span class="detail-overtime">Waktu Selesai</span></div>
                                    <div class="col-lg-8">'.$data->end_time.'</div>
                                    <div class="col-lg-4"><span class="detail-overtime">Durasi</span></div>
                                    <div class="col-lg-8">'.$data->duration.'</div>
                                    <div class="col-lg-4"><strong>Keterangan</strong></div>
                                    <div class="col-lg-8">'.$data->description.'</div>
                                </div>
                            </div>
                        </div>';
            })
            ->editColumn('status', function($data) {
                if ($data->status == 1) {
                    return '<span class="text-warning">Pending</span>';
                } elseif($data->status == 2) { 
                    return '<span class="text-success">Approve</span><span class="text-updated-by">Approved By: '.$data->updatedBy->empl_name.'</span>';
                } elseif($data->status == 3){
                    return '<span class="text-secondary">Cancelled</span>';
                }else {
                    return '<span class="text-danger">Reject</span><span class="text-updated-by">Rejected By: '.$data->updatedBy->empl_name.'</span>';
                }
            })
            ->addColumn('action', function($data){
                if ($data->status == 1 ) {
                    return '<span data-overtime-id="'.$data->overtime_id.'" data-status="2" class="update-status text-success approve-request">Approve</span><hr>
                        <span data-overtime-id="'.$data->overtime_id.'" data-status="0" class="update-status text-danger reject-request">Reject</span>';
                }
            })
            ->rawColumns(['detail_overtime', 'status', 'action'])
            ->make(true);
    }

    public function updateStatusRequestOvertime(Request $request)
    {
        $overtime = TrOvertime::where('id', $request->overtimeId)->first();
        $time = explode(':', $overtime->duration);
        $hours = (int)$time[0];

        $queryNotif = User::select(
                    'users.id',
                    'users.name',
                    'users.nip',
                    'users.device_token',
                    'ms_empl.division_id',
                    'ms_empl.avatar'
                )
                ->join('ms_empl', 'users.empl_id', '=', 'ms_empl.id')
                ->where('ms_empl.id', $overtime->empl_id)
                ->first();

        $notification = new Notification;

        if ($request->status == 2) {
            $overtime->update([
                'status' => $request->status,
                'updated_by' => Auth::guard('user')->user()->empl_id
            ]);
            $overtimeAmount = TrOvertimeAmount::create([
                'overtime_id' => $overtime->id,
                'empl_id' => $overtime->empl_id,
                'duration' => $overtime->duration,
                'total_amount' => ($hours * 10000)
            ]);

            $notification->type_transaction = 2;
            $notification->transaction_id = $overtime->tr_overtime_id;
            $notification->user_id = $queryNotif->id;
            $notification->read = false;
            $notification->save();
            $notification->toSingleDevice($queryNotif->device_token, 'Status Lembur', 'Selamat, Pengajuan lembur anda disetujui', null, route('overtime'));
        } elseif ($request->status == 0) {
            $overtime->update([
                'status' => $request->status,
                'updated_by' => Auth::guard('user')->user()->empl_id
            ]);

            $notification->type_transaction = 2;
            $notification->transaction_id = $overtime->tr_overtime_id;
            $notification->user_id = $queryNotif->id;
            $notification->read = false;
            $notification->save();
            $notification->toSingleDevice($queryNotif->device_token, 'Status Lembur', 'Maaf, Pengajuan lembur anda ditolak', null, route('overtime'));
        } else {
            $overtime->update(['status' => $request->status]);
        }

        
        return response()->json(['success' => 'Update Status Successfully']);
    }

    private function dateFormat($date)
    {
        $oldDate = $date;
        $arr = explode('-', $oldDate);
        $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
        return $newDate;
    }
}
