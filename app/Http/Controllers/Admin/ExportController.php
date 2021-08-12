<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LecturerExport;
use App\Exports\EmployeeExport;

class ExportController extends Controller
{
    public function exportEmployee()
	{
		return Excel::download(new EmployeeExport, 'data_pegawai.xlsx');
	}

    public function exportLecturer()
	{
		return Excel::download(new LecturerExport, 'data_dosen.xlsx');
	}
}
