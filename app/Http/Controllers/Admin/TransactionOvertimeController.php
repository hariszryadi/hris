<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TrOvertime;
use DataTables;
use DB;

class TransactionOvertimeController extends Controller
{
    protected $_view = 'backend.transaction-overtime.';

    public function index(Request $request)
    {
        if (request()->ajax()) {
            return Datatables::of(TrOvertime::orderBy('id', 'DESC')->get())
                ->addColumn('action', function($data){
                    return '<ul class="icons-list">
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right text-center">
                                        <li>
                                            <a href="javascript:void(0)" id="show" data-id="'.$data->id.'"><i class="icon-search4 text-success"></i> Detail</a>
                                        </li>
                                    </div>
                                </li>
                            </ul>';
                })
                ->editColumn('empl_id', function($drawings) {
                    return $drawings->empl->empl_name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view($this->_view.'index');
    }

    public function show(Request $request)
    {
        $data = TrOvertime::with('empl.division')
                    ->where('tr_overtime.id', $request->id)
                    ->get();

        return response()->json(['data' => $data]);
    }
}
