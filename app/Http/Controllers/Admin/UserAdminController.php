<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\PermissionRole;
use App\Models\Admin;
use App\Models\Role;
use DataTables;
use File;

class UserAdminController extends Controller
{
    protected $trash;
    protected $disabled;
    protected $_view = 'backend.user-admin.';

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Admin::orderBy('id')->get())
                ->addColumn('action', function($data){
                    if ($data->email == 'superadmin@tedc.id') {
                        $this->disabled = 'disabled';
                        $this->trash = 'text-secondary';
                    } else {
                        $this->disabled = '';
                        $this->trash = 'text-danger';
                    }

                    $x = '';
                    if (auth()->user()->roles()->first()->permission_role()->byId(10)->first()->update_right == true) {
                        $x .= '<li>
                                <a href="/admin/user-admin/'.$data->id.'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                            </li>';
                    }
                    if (auth()->user()->roles()->first()->permission_role()->byId(10)->first()->delete_right == true) {
                        $x .= '<li class="'.$this->disabled.'">
                            <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'" data-image="'.$data->avatar.'" '.$this->disabled.'><i class="icon-bin '.$this->trash.'"></i> Hapus</a>
                        </li>';
                    }

                    if (auth()->user()->roles()->first()->permission_role()->byId(10)->first()->update_right == true ||
                        auth()->user()->roles()->first()->permission_role()->byId(10)->first()->delete_right == true) {
                        return '<ul class="icons-list">
                                    <li>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right text-center">                                            
                                            '.$x.'
                                        </div>
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
        $role = Role::orderBy('id')->get();
        return view($this->_view.'create')->with(compact('role'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required'
        ]);

        $path = null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatar', ['disk' => 'public']);
        }

        $data = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $path
        ]);

        $admin = Admin::find($data->id);
        $admin->roles()->attach($request->role_id);

        return redirect()->route('admin.userAdmin.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $userAdmin = Admin::with('roles')->find($id);
        $role = Role::orderBy('id')->get();
        return view($this->_view.'edit')->with(compact('userAdmin', 'role'));
    }

    public function update(Request $request)
    {
        $data = [];
        $email = $request->email;
        $password = $request->password;
        $avatar = $request->file('avatar');
        $userAdmin = Admin::where('id', $request->id);

        if ($email != '') {
            $data['email'] = $email;
        }

        if ($password != '') {
            $data['password'] = Hash::make($password);
        }

        if ($avatar != '') {
            $path = $request->file('avatar')->store('avatar', ['disk' => 'public']);
            $avatar = $userAdmin->first()->avatar;
            $data['avatar'] = $path;
            $path = \storage_path('app/public/' . $avatar);
            File::delete($path);
        }

        $this->validate($request, [
            'name' => 'required'
        ]);

        $data['name'] = $request->name;

        $userAdmin->update($data);

        $admin = Admin::find($request->id);
        $admin->roles()->sync($request->role_id);

        return redirect()->route('admin.userAdmin.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $userAdmin = Admin::where('id', $request->id);
        $path = \storage_path('app/public/' . $request->image);
        File::delete($path);
        $userAdmin->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
