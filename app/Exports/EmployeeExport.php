<?php

namespace App\Exports;

use App\Models\MsEmployee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = MsEmployee::select(
            'ms_empl.nip',
            'ms_empl.empl_name',
            'ms_empl.birth_date',
            'ms_empl.address',
            'ms_empl.phone',
            'ms_empl.email',
            'ms_empl.gender',
            'ms_empl.religion',
            'ms_division.name'
        )->leftjoin(
            'ms_division',
            'ms_empl.division_id', '=',
            'ms_division.id'
        )->get();

        return $query;
    }

    public function headings() : array
    {
        return [
            "NIP", 
            "Nama", 
            "Tanggal Lahir",
            "Alamat",
            "No. Telp",
            "Email",
            "Jenis Kelamin",
            "Agama",
            "Divisi"
        ];
    }
}
