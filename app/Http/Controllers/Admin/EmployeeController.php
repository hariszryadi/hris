<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;
use App\Models\Division;
use App\Models\User;
use DataTables;

class EmployeeController extends Controller
{
    protected $_view = 'backend.employee.';

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Employee::orderBy('id', 'DESC')->get())
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
                                            <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'" data-image="' . $data->image . '"><i class="icon-bin text-danger"></i> Hapus</a>
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
        $division = Division::orderBy('id', 'ASC')->get();
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
            'division_id' => 'required',
            'image' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('employee', ['disk' => 'public']);
        }

        $data = Employee::create([
            'nip' => $request->nip,
            'empl_name' => $request->empl_name,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'phone' => '62' . $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'division_id' => $request->division_id,
            'image' => $path
        ]);

        User::create([
            'empl_id' => $data->id,
            'name' => $data->empl_name,
            'nip' => $data->nip,
            'password' => \bcrypt($data->nip),
            'status' => true
        ]);

        return redirect()->route('admin.employee.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $division = Division::orderBy('id', 'ASC')->get();
        $employee = Employee::find($id);
        return view($this->_view.'form')->with(compact('division', 'employee'));
    }

    public function update(Request $request)
    {
        $data = [];
        $image = $request->file('image');
        $employee = Employee::where('id', $request->id);

        if ($image != '') {
            $path = $request->file('image')->store('employee', ['disk' => 'public']);
            $image = $employee->first()->image;
            $data['image'] = $path;
            $path = \storage_path('app/public/' . $image);
            unlink($path);
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
        $data['phone'] = '62' + $request->phone;
        $data['email'] = $request->email;
        $data['gender'] = $request->gender;
        $data['religion'] = $request->religion;
        $data['division_id'] = $request->division_id;

        $employee->update($data);

        return redirect()->route('admin.employee.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $employee = Employee::where('id', $request->id);
        $path = \storage_path('app/public/' . $request->image);
        unlink($path);
        $employee->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
