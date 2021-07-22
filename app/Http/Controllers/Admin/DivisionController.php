<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MsDivision;
use DataTables;

class DivisionController extends Controller
{
    protected $_view = 'backend.division.';

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(MsDivision::orderBy('id')->get())
                ->addColumn('action', function($data){
                    $x = '';
                    if (auth()->user()->roles()->first()->permission_role()->byId(1)->first()->update_right == true) {
                        $x .= '<li>
                                    <a href="/admin/division/'.$data->id .'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                </li>';
                    }
                    if (auth()->user()->roles()->first()->permission_role()->byId(1)->first()->delete_right == true) {
                        $x .= '<li>
                                    <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'"><i class="icon-bin text-danger"></i> Hapus</a>
                                </li>';
                    }

                    if (auth()->user()->roles()->first()->permission_role()->byId(1)->first()->update_right == true ||
                    auth()->user()->roles()->first()->permission_role()->byId(1)->first()->delete_right == true) {
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
                ->make(true);
        }

        return view($this->_view.'index');
    }

    public function create()
    {
        return view($this->_view.'form');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        
        MsDivision::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.division.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $division = MsDivision::find($id);
        return view($this->_view.'form')->with(compact('division'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        MsDivision::where('id', $request->id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.division.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $division = MsDivision::where('id', $request->id);
        $division->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
