<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function account(){
        return view('account');
    }

    public function profile(User $user){
        return view('profile', ['user' => $user]);
    }


    public function changeName(Request $request){
        $request->validate([
            "name" => 'required|string'
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();

        return back();
    }

    public function searchUsers(Request $request){
        $validator = Validator::make($request->all(), [
            'str' => "required|string",
        ]);
        if($validator->fails()){
            return response()->json(null);
        }

        return response()->json(UserResource::collection(User::whereLike('name', strval($request->str))->get()));

    }



}
