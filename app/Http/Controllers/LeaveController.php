<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsTypeLeave;
use App\Models\MsCategoryLeave;
use App\Models\TrLeave;
use App\Models\User;
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
        $userId = Auth::guard('user')->user()->empl_id;
        $typeLeave = $request->type_leave;
        $categoryLeave = $request->category_leave;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $data = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'type_leave_id' => $typeLeave,
            'category_leave_id' => $categoryLeave,
            'status' => 0,
            'empl_id' => $userId
        ];
        TrLeave::create($data);
        
        return redirect()->route('leave')->with('success', 'Berhasil Melakukan Pengajuan Rencana Cuti');
    }
}
