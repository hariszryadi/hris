<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsEmployee;
use App\Models\MsDivision;
use App\Models\Slider;
use File;

class DashboardController extends Controller
{
    public function index()
    {
        $slider = Slider::orderBy('id')->get();
        return view('frontend.index')->with(compact('slider'));
    }

    public function profileSettings($id)
    {
        $empl = MsEmployee::find($id);
        $division = MsDivision::orderBy('id')->get();
        return view('frontend.profile-settings')->with(compact('empl', 'division'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $data = [];
            $avatar = $request->file('avatar');
            $empl = MsEmployee::where('id', $request->id);

            if ($avatar != '') {
                $path = $request->file('avatar')->store('employee', ['disk' => 'public']);
                $avatar = $empl->first()->avatar;
                $data['avatar'] = $path;
                $path = \storage_path('app/public/' . $avatar);
                // unlink($path);
                File::delete($path);
            }

            $this->validate($request, [
                'birth_date' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'gender' => 'required',
                'religion' => 'required',
            ]);

            $data['birth_date'] = $request->birth_date;
            $data['address'] = $request->address;
            $data['phone'] = $request->phone;
            $data['email'] = $request->email;
            $data['gender'] = $request->gender;
            $data['religion'] = $request->religion;

            $empl->update($data);

            return response()->json([
                'message' => 'Berhasil melakukan perubahan profile',
                'data' => $empl
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal melakukan perubahan profile',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
