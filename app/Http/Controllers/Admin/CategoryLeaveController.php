<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MsTypeLeave;
use App\Models\MsCategoryLeave;
use DataTables;

class CategoryLeaveController extends Controller
{
    protected $_view = 'backend.category-leave.';

    public function index(Request $request)
    {
        if (request()->ajax()) {
            return Datatables::of(MsCategoryLeave::orderBy('id')->get())
                ->addColumn('action', function($data){
                    $x = '';
                    if (auth()->user()->roles()->first()->permission_role()->byId(3)->first()->update_right == true) {
                        $x .= '<li>
                                    <a href="/admin/category-leave/'.$data->id .'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                </li>';
                    }
                    if (auth()->user()->roles()->first()->permission_role()->byId(3)->first()->delete_right == true) {
                        $x .= '<li>
                                    <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'"><i class="icon-bin text-danger"></i> Hapus</a>
                                </li>';
                    }

                    if (auth()->user()->roles()->first()->permission_role()->byId(3)->first()->update_right == true ||
                        auth()->user()->roles()->first()->permission_role()->byId(3)->first()->delete_right == true) {
                        return '<ul class="icons-list">
                                    <li>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right text-center">
                                            '.$x.'
                                        </ul>
                                    </li>
                                </ul>';
                    }
                })
                ->editColumn('type_leave_id', function($drawings) {
                    return $drawings->typeLeave->type_leave;
                })
                ->make(true);
        }

        return view($this->_view.'index');
    }

    public function create()
    {
        $typeLeave = MsTypeLeave::get();
        return view($this->_view.'form')->with(compact('typeLeave'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_leave' => 'required',
            'type_leave_id' => 'required'
        ]);
        
        MsCategoryLeave::create([
            'category_leave' => $request->category_leave,
            'type_leave_id' => $request->type_leave_id
        ]);

        return redirect()->route('admin.categoryLeave.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $typeLeave = MsTypeLeave::get();
        $categoryLeave = MsCategoryLeave::find($id);
        return view($this->_view.'form')->with(compact('typeLeave', 'categoryLeave'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'category_leave' => 'required',
            'type_leave_id' => 'required'
        ]);

        MsCategoryLeave::where('id', $request->id)->update([
            'category_leave' => $request->category_leave,
            'type_leave_id' => $request->type_leave_id
        ]);

        return redirect()->route('admin.categoryLeave.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $categoryLeave = MsCategoryLeave::where('id', $request->id);
        $categoryLeave->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
