<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\MsFunctionalPosition;
use App\Models\MsLecturer;
use App\Models\MsMajor;
use DataTables;
use File;

class LecturerController extends Controller
{
    protected $_view = 'backend.lecturer.';

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(MsLecturer::orderBy('id', 'DESC')->get())
                ->addColumn('action', function($data){
                    return '<ul class="icons-list">
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right text-center">                        
                                        <li>
                                            <a href="/admin/lecturer/'.$data->id .'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'" data-avatar="' . $data->avatar . '"><i class="icon-bin text-danger"></i> Hapus</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" id="show" data-id="'.$data->id.'"><i class="icon-search4 text-success"></i> Detail</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>';
                })
                ->editColumn('functional_position_id', function($drawings) {
                    if ($drawings->functional_position_id == '') return '-';
                    if ($drawings->functional_position->name != '') return $drawings->functional_position->name;
                })
                ->editColumn('major_id', function($drawings) {
                    return $drawings->major->name;
                })
                ->make(true);
        }

        return view($this->_view.'index');
    }

    public function create()
    {
        $functional_position = MsFunctionalPosition::orderBy('id', 'ASC')->get();
        $major = MsMajor::orderBy('id', 'ASC')->get();

        return view($this->_view.'form')->with(compact('functional_position', 'major'));
    }

    public function show(Request $request)
    {
        $data = MsLecturer::with('functional_position', 'major')
                    ->where('id', $request->id)
                    ->get();

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'no_reg' => 'required|unique:ms_lecturer',
            'name' => 'required',
            'last_education' => 'required',
            'certification' => 'required',
            'major_id' => 'required'
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('lecturer', ['disk' => 'public']);
        }

        MsLecturer::create([
            'no_reg' => $request->no_reg,
            'name' => $request->name,
            'functional_position_id' => $request->functional_position_id,
            'rank' => $request->rank,
            'last_education' => $request->last_education,
            'certification' => $request->certification,
            'certification_year' => $request->certification_year,
            'major_id' => $request->major_id,
            'avatar' => $request->hasFile('avatar') ? $path : null
        ]);

        return redirect()->route('admin.lecturer.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $functional_position = MsFunctionalPosition::orderBy('id', 'ASC')->get();
        $major = MsMajor::orderBy('id', 'ASC')->get();
        $lecturer = MsLecturer::find($id);

        return view($this->_view.'form')->with(compact('functional_position', 'major', 'lecturer'));
    }

    public function update(Request $request)
    {
        $data = [];
        $avatar = $request->file('avatar');
        $lecturer = MsLecturer::where('id', $request->id);

        if ($avatar != '') {
            $path = $request->file('avatar')->store('lecturer', ['disk' => 'public']);
            $avatar = $lecturer->first()->avatar;
            $data['avatar'] = $path;
            $path = \storage_path('app/public/' . $avatar);
            // unlink($path);
            File::delete($path);
        }

        $this->validate($request, [
            'no_reg' => 'required',
            'name' => 'required',
            'last_education' => 'required',
            'certification' => 'required',
            'major_id' => 'required'
        ]);

        $data['no_reg'] = $request->no_reg;
        $data['name'] = $request->name;
        $data['functional_position_id'] = $request->functional_position_id;
        $data['rank'] = $request->rank;
        $data['last_education'] = $request->last_education;
        $data['certification'] = $request->certification;
        $data['certification_year'] = $request->certification_year;
        $data['major_id'] = $request->major_id;

        $lecturer->update($data);

        return redirect()->route('admin.lecturer.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $lecturer = MsLecturer::where('id', $request->id);
        $path = \storage_path('app/public/' . $request->avatar);
        // unlink($path);
        File::delete($path);
        $lecturer->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
