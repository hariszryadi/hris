<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MsLecturer;

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
}
