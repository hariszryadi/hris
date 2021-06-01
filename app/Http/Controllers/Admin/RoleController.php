<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PermissionRole;
use App\Models\Permission;
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
        if (request()->ajax()) {
            return Datatables::of(Permission::orderBy('id')->get())
                ->addColumn('readable', function($data){
                    if ($data->readable == true) {
                        return '<input type="checkbox" name="readable_'.$data->id.'"/>';
                    }
                })
                ->addColumn('createable', function($data){
                    if ($data->createable == true) {
                        return '<input type="checkbox" name="createable_'.$data->id.'"/>';
                    }
                })
                ->addColumn('updateable', function($data){
                    if ($data->updateable == true) {
                        return '<input type="checkbox" name="updateable_'.$data->id.'"/>';
                    }
                })
                ->addColumn('deleteable', function($data){
                    if ($data->deleteable == true) {
                        return '<input type="checkbox" name="deleteable_'.$data->id.'"/>';
                    }
                })
                ->rawColumns(['readable', 'createable', 'updateable', 'deleteable'])
                ->make(true);
        }

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

        // Role::where('id', $request->id)->update([
        //     'name' => $request->name,
        //     'description' => $request->description
        // ]);

        // $permission = PermissionRole::where('role_id', $request->id)->get();
        // return dd($permission);
        // foreach ($permissions as $permission) {
            // $permissionRole = new PermissionRole;
            PermissionRole::where('role_id', $request->id)->update([
                'read_right' => true,
                'create_right' => $request->createable,
                'update_right' => $request->updateable,
                'delete_right' => $request->deleteable
            ]);
        // }

        return redirect()->route('admin.role.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $role = Role::where('id', $request->id);
        $role->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
