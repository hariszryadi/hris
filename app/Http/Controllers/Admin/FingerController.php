<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MsEmployee;
use App\Models\Finger;
use DataTables;

class FingerController extends Controller
{
    protected $_view = 'backend.finger.';

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Finger::orderBy('id_finger')->get())
                ->addColumn('action', function($data){
                    return '<ul class="icons-list">
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right text-center">
                                        <li>
                                            <a href="/admin/finger/'.$data->id .'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                        </li>    
                                        <li>
                                            <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'"><i class="icon-bin text-danger"></i> Hapus</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>';
                })
                ->make(true);
        }

        return view($this->_view.'index');
    }

    public function create()
    {
        $empl = MsEmployee::orderBy('empl_name')->get();

        return view($this->_view.'form')->with(compact('empl'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nip' => 'required|unique:id_finger',
            'id_finger' => 'required|unique:id_finger'
        ]);
        
        Finger::create([
            'nip' => $request->nip,
            'id_finger' => $request->id_finger,
        ]);

        return redirect()->route('admin.finger.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $finger = Finger::find($id);
        $empl = MsEmployee::orderBy('empl_name')->get();

        return view($this->_view.'form')->with(compact('finger', 'empl'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'nip' => 'required',
            'id_finger' => 'required'
        ]);

        Finger::where('id', $request->id)->update([
            'nip' => $request->nip,
            'id_finger' => $request->id_finger
        ]);

        return redirect()->route('admin.finger.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $division = Finger::where('id', $request->id);
        $division->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
