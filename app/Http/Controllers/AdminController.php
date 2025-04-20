<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard()
    {
        $user = auth()->user();
        return view('admin.dashboard',compact('user'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile',compact('user'));
    }


}