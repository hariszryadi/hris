<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use DataTables;

class RoleController extends Controller
{
    protected $_view = 'backend.role.';

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Role::orderBy('id')->get())
                ->addColumn('action', function($data){
                    return '<ul class="icons-list">
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right text-center">
                                        <li>
                                            <a href="/admin/role/'.$data->id .'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'"><i class="icon-bin text-danger"></i> Hapus</a>
                                        </li>
                                    </div>
                                </li>
                            </ul>';
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
        
        Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('admin.role.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view($this->_view.'form')->with(compact('role'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        Role::where('id', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('admin.role.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $role = Role::where('id', $request->id);
        $role->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}