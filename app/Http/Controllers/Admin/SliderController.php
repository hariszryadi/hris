<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;
use DataTables;
use File;

class SliderController extends Controller
{
    protected $_view = 'backend.slider.';

    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Slider::orderBy('id')->get())
                ->addColumn('action', function($data){
                    return '<ul class="icons-list">
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right text-center">
                                        <li>
                                            <a href="/admin/slider/'.$data->id .'/edit"><i class="icon-pencil5 text-primary"></i> Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" id="delete" data-id="'.$data->id.'" data-image="' . $data->image . '"><i class="icon-bin text-danger"></i> Hapus</a>
                                        </li>
                                    </div>
                                </li>
                            </ul>';
                })
                ->make(true);
        }

        return view($this->_view.'index');
    }

    public function create()
    {
        return view($this->_view.'form');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
            'caption' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('slider', ['disk' => 'public']);
        }

        $data = Slider::create([
            'image' => $path,
            'caption' => $request->caption
        ]);

        return redirect()->route('admin.slider.index')->with('success', 'Success Message');
    }

    public function edit($id)
    {
        $slider = Slider::find($id);
        return view($this->_view.'form')->with(compact('slider'));
    }

    public function update(Request $request)
    {
        $data = [];
        $image = $request->file('image');
        $slider = Slider::where('id', $request->id);

        if ($image != '') {
            $path = $request->file('image')->store('slider', ['disk' => 'public']);
            $image = $slider->first()->image;
            $data['image'] = $path;
            $path = \storage_path('app/public/' . $image);
            File::delete($path);
        }

        $this->validate($request, [
            'caption' => 'required'
        ]);

        $data['caption'] = $request->caption;

        $slider->update($data);

        return redirect()->route('admin.slider.index')->with('success', 'Success Message');
    }

    public function destroy(Request $request)
    {
        $slider = Slider::where('id', $request->id);
        $path = \storage_path('app/public/' . $request->image);
        File::delete($path);
        $slider->delete();

        return response()->json(['success' => 'Delete Data Successfully']);
    }
}
