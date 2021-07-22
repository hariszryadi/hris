<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use DataTables;

class AccountController extends Controller
{
    protected $_view = 'backend.account.';

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(User::orderBy('id', 'DESC')->get())
                ->addColumn('action', function($data){
                    $status = '';
                    if ($data->status == true) {
                        $status .='<a href="javascript:void(0)" id="nonaktif" data-id="'.$data->id.'" data-status="'.$data->status.'"><i class="icon-user-block text-danger"></i>Nonaktif</a>';
                    } else {
                        $status .='<a href="javascript:void(0)" id="aktif" data-id="'.$data->id.'" data-status="'.$data->status.'"><i class="icon-user-check text-success"></i>Aktif</a>';
                    }

                    if (auth()->user()->roles()->first()->permission_role()->byId(8)->first()->update_right == true) {
                        return '<ul class="icons-list">
                                    <li>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right text-center">
                                            <li>
                                                <a href="/admin/account/'.$data->id .'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                            </li>
                                            <li>'
                                                .$status.
                                            '</li>
                                        </ul>
                                    </li>
                                </ul>';
                    }
                })
                ->editColumn('status', function($data) {
                    return ($data->status == true) ? '<span class="text-success">Active</span>' : 
                            '<span class="text-danger">Disable</span>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view($this->_view.'index');
    }

    public function edit($id)
    {
        $account = User::find($id);
        return view($this->_view.'form')->with(compact('account'));
    }

    public function update(Request $request)
    {
        $password = $request->password;

        if ($password != '') {
            User::where('id', $request->id)->update([
                'password' => \bcrypt($password)
            ]);
        }

        return redirect()->route('admin.account.index')->with('success', 'Success Message');
    }

    public function changeStatus(Request $request)
    {
        $user = User::where('id', $request->id);
        if ($request->status == true) {
            $user->update(['status' => false]);
        }
        if($request->status == false) {
            $user->update(['status' => true]);
        }
    }
}
