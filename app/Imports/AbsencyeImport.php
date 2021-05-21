<?php

namespace App\Imports;

use App\Models\MsEmployee;
use App\Models\TrImportAbsencye;
use Maatwebsite\Excel\Concerns\ToModel;

class AbsencyeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $emplId = MsEmployee::select('id')->where('empl_name', $row[1])->get();

        return new TrImportAbsencye([
            'empl_id' => $emplId[0]->id,
            'time_entry' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'time_return' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])
        ]);
    }
}
