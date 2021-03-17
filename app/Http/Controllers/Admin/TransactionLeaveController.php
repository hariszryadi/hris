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
                ->editColumn('empl_id', function($drawings) {
                    return $drawings->empl->empl_name;
                })
                ->editColumn('category_leave_id', function($drawings) {
                    return $drawings->categoryLeave->category_leave;
                })
                ->editColumn('status', function($data) {
                    if ($data->status == 1) {
                        return '<span class="badge bg-orange">Pending</span>';
                    } elseif ($data->status == 2) {
                        return '<span class="badge bg-success">Approve</span>';
                    } else {
                        return '<span class="badge bg-danger">Reject</span>';
                    }
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view($this->_view.'index');
    }
}
