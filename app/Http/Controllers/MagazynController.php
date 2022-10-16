<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produkt;

class MagazynController extends Controller
{
    public function magazyn()
    {
        $magazyn_items= Produkt::all();
        return view('magazyn',compact('magazyn_items'));
    }
}

