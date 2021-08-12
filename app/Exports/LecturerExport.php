<?php

namespace App\Exports;

use App\Models\MsLecturer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LecturerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = MsLecturer::select(
            'ms_lecturer.no_reg',
            'ms_lecturer.name as name',
            'ms_functional_position.name as functional_position',
            'ms_lecturer.rank',
            'ms_lecturer.last_education',
            'ms_lecturer.certification',
            'ms_lecturer.certification_year',
            'ms_major.name as major'
        )->leftjoin(
            'ms_functional_position', 
            'ms_lecturer.functional_position_id', '=', 
            'ms_functional_position.id'
        )->leftjoin(
            'ms_major', 
            'ms_lecturer.major_id', '=', 
            'ms_major.id'
        )->get();

        foreach ($query as $key => $value) {
            $collection[] = [
                'no_reg' => $value->no_reg,
                'name' => $value->name,
                'functional_position' => $value->functional_position,
                'rank' => $value->rank,
                'last_education' => $value->last_education,
                'certification' => ($value->certification == true ? 'Sertifikasi' : 'Belum Sertifikasi'),
                'certification_year' => $value->certification_year,
                'major' => $value->major
            ];
        }
        $result = collect($collection);
        return $result;
    }

    public function headings() : array
    {
        return [
            "No. Registrasi", 
            "Nama", 
            "Jabatan Fungsional",
            "Kepangkatan",
            "Pendidikan Terakhir",
            "Sertifikasi Dosen",
            "Tahun Sertifikasi",
            "Penempatan"
        ];
    }
}
