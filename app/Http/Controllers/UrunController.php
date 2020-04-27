<?php

namespace App\Http\Controllers;

use App\Models\Urun;
use Illuminate\Http\Request;


class UrunController extends Controller
{
    public function index($slug){
        $urun = Urun::where('slug',$slug)->firstOrFail();
        return view('urun',compact('urun'));
    }
}
