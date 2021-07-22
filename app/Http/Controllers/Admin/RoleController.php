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
                    $x = '';
                    if (auth()->user()->roles()->first()->permission_role()->byId(9)->first()->update_right == true) {
                        $x .= '<li>
                                    <a href="/admin/role/'.$data->id .'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                </li>';
                    }
                    if (auth()->user()->roles()->first()->permission_role()->byId(9)->first()->delete_right == true) {
                        $x .= '<li>
                                    <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'"><i class="icon-bin text-danger"></i> Hapus</a>
                                </li>';
                    }

                    if (auth()->user()->roles()->first()->permission_role()->byId(9)->first()->update_right == true ||
                        auth()->user()->roles()->first()->permission_role()->byId(9)->first()->delete_right == true) {
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
        
        $data = Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            $permissionRole = new PermissionRole;

            $permissionRole->permission_id = $permission->id;
            $permissionRole->role_id = $data->id;
            if ($permission->readable == true) {
                $permissionRole->read_right = $request->get("readable_".$permission->id) != null ? true : false;
            }
            if ($permission->createable == true) {
                $permissionRole->create_right = $request->get("createable_".$permission->id) != null ? true : false;
            }
            if ($permission->updateable == true) {
                $permissionRole->update_right = $request->get("updateable_".$permission->id) != null ? true : false;
            }
            if ($permission->deleteable == true) {
                $permissionRole->delete_right = $request->get("deleteable_".$permission->id) != null ? true : false;
            }
            
            $permissionRole->save();
        }

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

        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            $data = [];
            $permissionRole = PermissionRole::where('role_id', $request->id)->where('permission_id', $permission->id);
            
            if ($permission->readable == true) {
                if ($request->get("readable_".$permission->id) != null) {
                    $data['read_right'] = true;
                } else {
                    $data['read_right'] = false;
                }
            }

            if ($permission->createable == true) {
                if ($request->get("createable_".$permission->id) != null) {
                    $data['create_right'] = true;
                } else {
                    $data['create_right'] = false;
                }
            }

            if ($permission->updateable == true) {
                if ($request->get("updateable_".$permission->id) != null) {
                    $data['update_right'] = true;
                } else {
                    $data['update_right'] = false;
                }
            }
            
            if ($permission->deleteable == true) {
                if ($request->get("deleteable_".$permission->id) != null) {
                    $data['delete_right'] = true;
                } else {
                    $data['delete_right'] = false;
                }
            }
            

            $permissionRole->update($data);
        }

        return redirect()->route('admin.role.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $role = Role::where('id', $request->id);
        $role->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }

    public function dataTablePermission(Request $request)
    {
        if ($request->id == null) {
            $query = Permission::select(
                'permissions.id as id',
                'permissions.code',
                'permissions.name as name',
                'permissions.readable',
                'permissions.createable',
                'permissions.updateable',
                'permissions.deleteable'
            )
            ->get();
            
            return response()->json($query);
        } else {
            $query = Permission::select(
                        'permissions.id as id',
                        'permissions.code',
                        'permissions.name as name',
                        'permissions.readable',
                        'permissions.createable',
                        'permissions.updateable',
                        'permissions.deleteable',
                        'permission_role.read_right',
                        'permission_role.create_right',
                        'permission_role.update_right',
                        'permission_role.delete_right',
                        'roles.id as role_id',
                        'roles.name as role_name'
                    )
                    ->join('permission_role', 'permissions.id', '=', 'permission_role.permission_id')
                    ->join('roles', 'permission_role.role_id', '=', 'roles.id')
                    ->where('roles.id', '=', $request->id)
                    ->get();

            return response()->json($query);
        }
    }
}
