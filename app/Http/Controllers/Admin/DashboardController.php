<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MsLecturer;
use App\Models\MsEmployee;

class DashboardController extends Controller
{
    public function getCountLecturer(Request $request)
    {
        $lecturer = MsLecturer::get();
        $assisten_ahli_count = $lecturer->where('functional_position_id', 4)->count();
        $lektor_count = $lecturer->where('functional_position_id', 3)->count();
        $lektor_kepala_count = $lecturer->where('functional_position_id', 2)->count();
        $guru_besar_count = $lecturer->where('functional_position_id', 1)->count();
        $tenaga_pengajar_count = $lecturer->where('functional_position_id', null)->count();

        return response()->json([
            'asisten_ahli' => $assisten_ahli_count,
            'lektor' => $lektor_count,
            'lektor_kepala' => $lektor_kepala_count,
            'guru_besar' => $guru_besar_count,
            'tenaga_pengajar' => $tenaga_pengajar_count
        ]);
    }

    public function getCountEmployee(Request $request)
    {
        $empl = MsEmployee::get();
        $akademik_count = $empl->where('division_id', 1)->count();
        $kepegawaian_count = $empl->where('division_id', 2)->count();
        $kemahasiswaan_count = $empl->where('division_id', 3)->count();
        $keuangan_count = $empl->where('division_id', 4)->count();
        $umum_count = $empl->where('division_id', 5)->count();
        $upm_count = $empl->where('division_id', 6)->count();
        $upipv_count = $empl->where('division_id', 7)->count();
        $ukh_count = $empl->where('division_id', 8)->count();
        $upust_count = $empl->where('division_id', 9)->count();
        $uppm_count = $empl->where('division_id', 10)->count();
        $upj_count = $empl->where('division_id', 11)->count();
        $usuk_count = $empl->where('division_id', 12)->count();
        $usimp_count = $empl->where('division_id', 13)->count();

        return response()->json([
            'akademik' => $akademik_count,
            'kepegawaian' => $kepegawaian_count,
            'kemahasiswaan' => $kemahasiswaan_count,
            'keuangan' => $keuangan_count,
            'umum' => $umum_count,
            'upm' => $upm_count,
            'upipv' => $upipv_count,
            'ukh' => $ukh_count,
            'upust' => $upust_count,
            'uppm' => $uppm_count,
            'upj' => $upj_count,
            'usuk' => $usuk_count,
            'usimp' => $usimp_count
        ]);
    }
}
