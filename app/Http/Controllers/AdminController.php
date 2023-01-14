<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home()
    {
        return view('admin');
    }
    public function makeAdmin(User $user){
        $user->assignRole('admin');
        return back()->with('success', 'User ' . $user->name . ' Został dodany jako Administrator');
    }

    public function removeAdmin(User $user){
        $user->removeRole('admin');
        return back()->with('success', 'User ' . $user->name . ' Został usunięty z roli Administratora');
    }

    public function manageUsers()
    {

        return view('manageUsers');
    }

}
