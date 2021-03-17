<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsCategoryLeave;
use App\Models\MsTypeLeave;
use App\Models\TrLeave;
use Carbon\Carbon;
use Auth;

class LeaveController extends Controller
{
    protected $_view = 'frontend.leave';

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

    public function submitStartDateLeave(Request $request)
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

    public function submitEndDateLeave(Request $request)
    {
        $trLeave = new TrLeave;
        $trLeave->start_date = $request->start_date;
        $trLeave->end_date = $request->end_date;
        $trLeave->type_leave_id = $request->type_leave;
        $trLeave->category_leave_id = $request->category_leave;
        $trLeave->status = 1;
        if($request->description == null)  {
            $trLeave->description = "-";
        } else {
            $trLeave->description =  $request->description ;
        }
        $trLeave->empl_id = Auth::guard('user')->user()->empl_id;
        $trLeave->save();
        $trLeave->update(['tr_leave_id' => \sprintf("LV-".Carbon::now()->format('Ymd')."%04d", $trLeave->id)]);

        return redirect()->route('leave')->with('success', 'Berhasil Melakukan Pengajuan Rencana Cuti');
    }
}
