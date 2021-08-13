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
        $empl = MsEmployee::orderBy('empl_name')->get();

        return view($this->_view.'leave.index')->with(compact('empl'));
    }

    public function downloadReportLeave(Request $request)
    {
        $query = TrLeave::with(['typeLeave', 'categoryLeave', 'empl.division'])
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);

        if ($request->empl_id !== "null") {
            $query->where('empl_id', '=', $request->empl_id);
        }
        $data = $query->orderBy('id')->get();
        $status = $data->countBy('status');

        $pdf = PDF::loadview($this->_view.'leave.report',[
            'data' => $data, 
            'status' => $status, 
            'start_date' => \Carbon\Carbon::parse($request->start_date)->format('d/m/Y'),
            'end_date' => \Carbon\Carbon::parse($request->end_date)->format('d/m/Y')
        ]);
        return $pdf->stream('report_leave.pdf')
                ->header('Content-Type','application/pdf');
    }

    public function reportOvertime()
    {
        $empl = MsEmployee::orderBy('empl_name')->get();

        return view($this->_view.'overtime.index')->with(compact('empl'));
    }

    public function downloadReportOvertime(Request $request)
    {
        $query = TrOvertime::with('empl.division')
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);

        if ($request->empl_id !== "null") {
            $query->where('empl_id', '=', $request->empl_id);
        }
        $data = $query->orderBy('id')->get();
        $status = $data->countBy('status');

        $pdf = PDF::loadview($this->_view.'overtime.report',[
            'data' => $data, 
            'status' => $status,
            'start_date' => \Carbon\Carbon::parse($request->start_date)->format('d/m/Y'),
            'end_date' => \Carbon\Carbon::parse($request->end_date)->format('d/m/Y')
        ]);
        return $pdf->stream('report_overtime.pdf')
                ->header('Content-Type','application/pdf');
    }
}
