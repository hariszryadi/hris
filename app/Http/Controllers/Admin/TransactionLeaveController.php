<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TrLeave;
use DataTables;

class TransactionLeaveController extends Controller
{
    protected $_view = 'backend.transaction-leave.';

    public function index(Request $request)
    {
        if (request()->ajax()) {
            return Datatables::of(TrLeave::orderBy('id', 'DESC')->get())
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
                ->editColumn('category_leave_id', function($drawings) {
                    return $drawings->categoryLeave->category_leave;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view($this->_view.'index');
    }

    public function show(Request $request)
    {
        $data = TrLeave::with(['typeLeave', 'categoryLeave', 'empl.division'])
                    ->where('tr_leave.id', $request->id)
                    ->get();

        return response()->json(['data' => $data]);
    }
}
