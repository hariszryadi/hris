<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class WelcomeController extends Controller
{
    public function index()
    {
        $slider = Slider::get();
        return view('welcome')->with(compact('slider'));
    }
}
