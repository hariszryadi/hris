<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MsEmployee;
use App\Models\TrOvertime;
use App\Models\TrLeave;
use PDF;
use DB;

class ReportController extends Controller
{
    protected $_view = 'backend.report.';

    public function reportLeave()
    {
        $empl = MsEmployee::orderBy('nip')->get();

        return view($this->_view.'leave.index')->with(compact('empl'));
    }

    public function downloadReportLeave(Request $request)
    {
        $query = TrLeave::with(['typeLeave', 'categoryLeave', 'empl.division'])
                ->whereYear('created_at', $request->year);
                // ->whereMonth('created_at', $request->month)
                // ->orderBy('id')
                // ->get();
        if ($request->month != "null") {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->empl_id !== "null") {
            $query->where('empl_id', '=', $request->empl_id);
        }
        $data = $query->orderBy('id')->get();

        $pdf = PDF::loadview($this->_view.'leave.report',['data'=>$data]);
        return $pdf->stream('report_leave.pdf')
                ->header('Content-Type','application/pdf');
    }

    public function reportOvertime()
    {
        $empl = MsEmployee::orderBy('nip')->get();

        return view($this->_view.'overtime.index')->with(compact('empl'));
    }

    public function downloadReportOvertime(Request $request)
    {
        $query = TrOvertime::with('empl.division')
                ->whereYear('created_at', $request->year);
                
        if ($request->month != "null") {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->empl_id !== "null") {
            $query->where('empl_id', '=', $request->empl_id);
        }
        $data = $query->orderBy('id')->get();

        $pdf = PDF::loadview($this->_view.'overtime.report',['data'=>$data]);
        return $pdf->stream('report_overtime.pdf')
                ->header('Content-Type','application/pdf');
    }
}
