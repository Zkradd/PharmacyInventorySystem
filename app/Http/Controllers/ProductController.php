<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function magazyn()
    {
        $products= Product::all();
        return view('magazyn',compact('products'));
    }

    public function addItem(Request $request){
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required'],
            'quantity' => ['required'],
            'description' => ['required', 'string'],
        ]);

        $item = new Product();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->quantity = $request->quantity;
        $item->description = $request->description;
        $item->save();
        

    }



}

