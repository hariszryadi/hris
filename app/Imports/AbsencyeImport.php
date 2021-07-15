<?php

namespace App\Imports;

use App\Models\TrImportAbsencye;
use Maatwebsite\Excel\Concerns\ToModel;
use Auth;

class AbsencyeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TrImportAbsencye([
            'id_finger' => $row[0],
            'empl_name' => $row[1],
            'absencye_date' => $row[2],
            // 'time_entry' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            // 'time_return' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])
            'time_entry' => $row[3],
            'time_return' => $row[4],
            'user' => Auth::guard('admin')->user()->name
        ]);
    }
}
