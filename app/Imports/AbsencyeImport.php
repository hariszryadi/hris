<?php

namespace App\Imports;

use App\Models\TrImportAbsencye;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;

class AbsencyeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $emplId = DB::table('ms_empl')->select('id')->where('empl_name', ucwords(strtolower($row[1])))->get();
        $id = $emplId[0]->id;
        return new TrImportAbsencye([
            'empl_id' => $row[1],
            'time_entry' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'time_return' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])
        ]);
    }
}
