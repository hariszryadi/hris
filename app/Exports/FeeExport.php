<?php

namespace App\Exports;

use App\Models\TrImportAbsencye;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class FeeExport implements FromCollection, WithHeadings
{
    protected $empl_id;
    protected $start_date;
    protected $end_date;
    
    function __construct($empl_id, $start_date, $end_date) {
        $this->empl_id = $empl_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->empl_id !== "null") {
            $query = TrImportAbsencye::select(
                'tr_import_absencye.empl_name',
                'ms_finger.nip',
                DB::raw('count(tr_import_absencye.empl_name) as jumlah_masuk'),
                DB::raw('count(tr_import_absencye.empl_name) * 10000 as uang_makan'),
                'overtime.durasi',
                'overtime_amount.uang_lembur',
                DB::raw('((count(tr_import_absencye.empl_name) * 10000) + coalesce(overtime_amount.uang_lembur, 0)) as total')
            )->join(
                'ms_finger', 
                'tr_import_absencye.id_finger', '=',
                'ms_finger.id_finger'
            )->leftjoin(
                DB::raw("
                    (SELECT tr_overtime.empl_id, SUM ( tr_overtime.duration ) AS durasi 
                    FROM tr_overtime 
                    WHERE tr_overtime.overtime_date >= '".$this->start_date."' 
                    AND tr_overtime.overtime_date <= '".$this->end_date."'
                    GROUP BY tr_overtime.empl_id) 
                    AS overtime"), 
                'overtime.empl_id', '=', 
                'ms_finger.empl_id'
            )->leftjoin(
                DB::raw("
                    (SELECT tr_overtime_amount.empl_id, SUM ( tr_overtime_amount.total_amount::int ) AS uang_lembur 
                    FROM tr_overtime_amount 
                    GROUP BY tr_overtime_amount.empl_id) 
                    AS overtime_amount"), 
                'overtime_amount.empl_id', '=', 
                'overtime.empl_id'
            )
            ->where('tr_import_absencye.time_entry', '<>', '')
            ->where('tr_import_absencye.time_return', '<>', '')
            ->whereDate('tr_import_absencye.absencye_date', '>=', $this->start_date)
            ->whereDate('tr_import_absencye.absencye_date', '<=', $this->end_date)
            ->where('ms_finger.empl_id', '=', $this->empl_id)
            ->groupBy('tr_import_absencye.empl_name', 'ms_finger.nip', 'overtime.durasi', 'overtime_amount.uang_lembur')
            ->get();

            return $query;

        } else {
            
            $query = TrImportAbsencye::select(
                'tr_import_absencye.empl_name',
                'ms_finger.nip',
                DB::raw('count(tr_import_absencye.empl_name) as jumlah_masuk'),
                DB::raw('count(tr_import_absencye.empl_name) * 10000 as uang_makan'),
                'overtime.durasi',
                'overtime_amount.uang_lembur',
                DB::raw('((count(tr_import_absencye.empl_name) * 10000) + coalesce(overtime_amount.uang_lembur, 0)) as total')
            )->join(
                'ms_finger', 
                'tr_import_absencye.id_finger', '=',
                'ms_finger.id_finger'
            )->leftjoin(
                DB::raw("
                    (SELECT tr_overtime.empl_id, SUM ( tr_overtime.duration ) AS durasi 
                    FROM tr_overtime 
                    WHERE tr_overtime.overtime_date >= '".$this->start_date."' 
                    AND tr_overtime.overtime_date <= '".$this->end_date."'
                    GROUP BY tr_overtime.empl_id) 
                    AS overtime"), 
                'overtime.empl_id', '=', 
                'ms_finger.empl_id'
            )->leftjoin(
                DB::raw("
                    (SELECT tr_overtime_amount.empl_id, SUM ( tr_overtime_amount.total_amount::int ) AS uang_lembur 
                    FROM tr_overtime_amount 
                    GROUP BY tr_overtime_amount.empl_id) 
                    AS overtime_amount"), 
                'overtime_amount.empl_id', '=', 
                'overtime.empl_id'
            )
            ->where('tr_import_absencye.time_entry', '<>', '')
            ->where('tr_import_absencye.time_return', '<>', '')
            ->whereDate('tr_import_absencye.absencye_date', '>=', $this->start_date)
            ->whereDate('tr_import_absencye.absencye_date', '<=', $this->end_date)
            ->groupBy('tr_import_absencye.empl_name', 'ms_finger.nip', 'overtime.durasi', 'overtime_amount.uang_lembur')
            ->orderBy('tr_import_absencye.empl_name')
            ->get();

            // $query = DB::statement(
            //     "SELECT
            //         tr_import_absencye.empl_name,
            //         ms_finger.nip,
            //         COUNT ( tr_import_absencye.empl_name ) AS jumlah_masuk,
            //         COUNT ( tr_import_absencye.empl_name ) * 10000 AS uang_makan,
            //         overtime.durasi,
            //         overtime_amount.uang_lembur,
            //         (COUNT ( tr_import_absencye.empl_name ) * 10000) + overtime_amount.uang_lembur AS total
            //     FROM
            //         tr_import_absencye
            //         INNER JOIN ms_finger ON tr_import_absencye.id_finger = ms_finger.id_finger
            //         LEFT JOIN ( SELECT tr_overtime.empl_id, SUM ( tr_overtime.duration ) AS durasi FROM tr_overtime GROUP BY tr_overtime.empl_id ) overtime ON overtime.empl_id = ms_finger.empl_id
            //         LEFT JOIN ( SELECT tr_overtime_amount.empl_id, SUM ( tr_overtime_amount.total_amount :: INT ) AS uang_lembur FROM tr_overtime_amount GROUP BY tr_overtime_amount.empl_id ) overtime_amount ON overtime_amount.empl_id = overtime.empl_id 
            //     WHERE
            //         tr_import_absencye.time_return <> '' 
            //         AND tr_import_absencye.time_entry <> '' 
            //     GROUP BY
            //         tr_import_absencye.empl_name,
            //         ms_finger.nip,
            //         overtime.durasi,
            //         overtime_amount.uang_lembur 
            //     ORDER BY
            //         tr_import_absencye.empl_name"
            // );

            return $query;
        }
    }

    public function headings() : array
    {
        return [
            "Nama", 
            "NIP", 
            "Jumlah Masuk",
            "Uang Makan",
            "Durasi Lembur",
            "Uang Lembur",
            "Total"
        ];
    }
}
