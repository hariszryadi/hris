<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsTypeLeave;
use App\Models\MsCategoryLeave;

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

    public function requestLeave(Request $request)
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
}
