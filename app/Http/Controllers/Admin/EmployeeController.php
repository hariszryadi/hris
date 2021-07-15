<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\MsEmployee;
use App\Models\MsDivision;
use App\Models\User;
use App\Models\TrLeaveQuota;
use DataTables;
use File;

class EmployeeController extends Controller
{
    protected $_view = 'backend.employee.';

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(MsEmployee::orderBy('nip', 'DESC')->get())
                ->addColumn('action', function($data){
                    return '<ul class="icons-list">
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right text-center">
                                        <li>
                                            <a href="/admin/employee/'.$data->id .'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'" data-avatar="' . $data->avatar . '"><i class="icon-bin text-danger"></i> Hapus</a>
                                        </li>
                                    </div>
                                </li>
                            </ul>';
                })
                ->editColumn('division_id', function($drawings) {
                    return $drawings->division->name;
                })
                ->make(true);
        }

        return view($this->_view.'index');
    }

    public function create()
    {
        $division = MsDivision::orderBy('id', 'ASC')->get();
        return view($this->_view.'form')->with(compact('division'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nip' => 'required|unique:ms_empl',
            'empl_name' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:ms_empl',
            'gender' => 'required',
            'religion' => 'required',
            'division_id' => 'required'
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('employee', ['disk' => 'public']);
        }

        $data = MsEmployee::create([
            'nip' => $request->nip,
            'empl_name' => $request->empl_name,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'phone' => '62' . $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'division_id' => $request->division_id,
            'avatar' => $request->hasFile('avatar') ? $path : null
        ]);

        User::create([
            'empl_id' => $data->id,
            'name' => $data->empl_name,
            'nip' => $data->nip,
            'password' => \bcrypt($data->nip),
            'status' => true
        ]);

        TrLeaveQuota::create([
            'used_quota' => 0,
            'max_quota' => 12,
            'empl_id' => $data->id
        ]);

        return redirect()->route('admin.employee.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $division = MsDivision::orderBy('id', 'ASC')->get();
        $employee = MsEmployee::find($id);
        $phone = $employee->phone;
        $sub_str_phone = \substr($phone, 2);
        return view($this->_view.'form')->with(compact('division', 'employee', 'sub_str_phone'));
    }

    public function update(Request $request)
    {
        $data = [];
        $avatar = $request->file('avatar');
        $employee = MsEmployee::where('id', $request->id);

        if ($avatar != '') {
            $path = $request->file('avatar')->store('employee', ['disk' => 'public']);
            $avatar = $employee->first()->avatar;
            $data['avatar'] = $path;
            $path = \storage_path('app/public/' . $avatar);
            // unlink($path);
            File::delete($path);
        }

        $this->validate($request, [
            'nip' => 'required',
            'empl_name' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'division_id' => 'required',
        ]);

        $data['nip'] = $request->nip;
        $data['empl_name'] = $request->empl_name;
        $data['birth_date'] = $request->birth_date;
        $data['address'] = $request->address;
        $data['phone'] = '62' . $request->phone;
        $data['email'] = $request->email;
        $data['gender'] = $request->gender;
        $data['religion'] = $request->religion;
        $data['division_id'] = $request->division_id;

        $employee->update($data);

        User::where('empl_id', $request->id)->update([
            'name' => $request->empl_name,
            'nip' => $request->nip,
            'password' => \bcrypt($request->nip),
        ]);

        return redirect()->route('admin.employee.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $employee = MsEmployee::where('id', $request->id);
        $path = \storage_path('app/public/' . $request->avatar);
        // unlink($path);
        File::delete($path);
        $employee->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
