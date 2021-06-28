<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use DataTables;
use File;

class UserAdminController extends Controller
{
    protected $_view = 'backend.user-admin.';
    protected $disabled;
    protected $trash;

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

                    return '<ul class="icons-list">
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right text-center">
                                        <li>
                                            <a href="/admin/user-admin/'.$data->id.'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                        </li>
                                        <li class="'.$this->disabled.'">
                                            <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'" data-image="'.$data->avatar.'" '.$this->disabled.'><i class="icon-bin '.$this->trash.'"></i> Hapus</a>
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
        return view($this->_view.'create');
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

        return redirect()->route('admin.userAdmin.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $userAdmin = Admin::find($id);
        return view($this->_view.'edit')->with(compact('userAdmin'));
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
            $data['password'] = $password;
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
