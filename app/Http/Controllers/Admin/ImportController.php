<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TrImportAbsencye;
use App\Imports\AbsencyeImport;
use DataTables;
use DB;

class ImportController extends Controller
{
    protected $_view = 'backend.import.';

    public function index()
    {
        $query = DB::table('tr_import_absencye')
                    ->select(DB::raw('DATE(created_at) as date'), 'user')
                    ->groupBy('date', 'user')
                    ->get();

        if (request()->ajax()) {
            return Datatables::of($query)
                ->make(true);
        }
        return view($this->_view.'index');
    }

    public function importAbsencye(Request $request)
    {
        // validasi
		$this->validate($request, [
			'file' => 'required|mimes:xls,xlsx'
		]);
 
        try {
            // menangkap file excel
            $file = $request->file('file');
    
            // $path = $request->file('file')->getRealPath();
    
            // $data = Excel::load($path)->get();
    
            // if ($data->count() > 0) {
            //     foreach ($data->toArray() as $key => $value) {
            //         foreach ($value as $row) {
            //             $insert_data[] = [
    
            //                 'empl_id' => $row['']
    
            //             ];
            //         }
            //     }
            // }
    
            // membuat nama file unik
            // $nama_file = rand().$file->getClientOriginalName();
     
            // upload ke folder file_siswa di dalam folder public
            $import = $file->store('import/absencye', ['disk' => 'public']);
            // $file->move('import',$nama_file);
    
            // import data
            Excel::import(new AbsencyeImport, \storage_path('app/public/' . $import));
            // Excel::import(new AbsencyeImport, public_path('/import/'.$nama_file));
     
            // notifikasi dengan session
            // Session::flash('sukses','Data Berhasil Diimport!');
     
            // alihkan halaman kembali
            return response()->json(['success' => 'Data berhasil diimport!']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal melakukan import absensi',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
