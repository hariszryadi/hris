<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TrImportAbsencye;
use App\Imports\AbsencyeImport;
use Carbon\Carbon;
use DataTables;
use DB;

class ImportController extends Controller
{
    protected $_view = 'backend.import.';

    public function index()
    {
        // $max = DB::table('tr_import_absencye')->max('id') + 1;
        // DB::statement('ALTER SEQUENCE tr_import_absencye_id_seq RESTART WITH ' . $max);

        $query = DB::table('tr_import_absencye')
                ->select(DB::raw('DATE(created_at) as date'), 'user')
                ->groupBy('date', 'user')
                ->get();

        if (request()->ajax()) {
            return Datatables::of($query)
                ->addColumn('action', function($data){
                    if (auth()->user()->roles()->first()->permission_role()->byId(6)->first()->delete_right == true) {
                        return '<ul class="icons-list">
                                    <li>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right text-center">
                                            <li>
                                                <a href="javascript:void(0)" id="delete" data-date="'.$data->date.'"><i class="icon-bin text-danger"></i> Hapus</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>';
                    }
                })
                ->make(true);
        }
        return view($this->_view.'index');
    }

    public function importAbsencye(Request $request)
    {
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        // validation
		$this->validate($request, [
			'file' => 'required|mimes:xls,xlsx'
		]);

        $query = DB::table('tr_import_absencye')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();

        if ($query) {
            return response()->json([
                'message' => 'Import telah dilakukan sebelumnya'
            ], 400);
        }
 
        try {
            // get file excel
            $file = $request->file('file');
    
            // unique name
            // $nama_file = rand().$file->getClientOriginalName();
     
            // upload to folder public
            $import = $file->store('import/absencye', ['disk' => 'public']);
    
            // import data
            Excel::import(new AbsencyeImport, \storage_path('app/public/' . $import));
            // Excel::import(new AbsencyeImport, public_path('/import/'.$nama_file));
     
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal melakukan import absensi',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy(Request $request)
    {
        $division = TrImportAbsencye::whereDate('created_at', $request->created_at);
        $division->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
