<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users(Request $request)
    {
        $user = auth()->user();

        $queryUsers = User::query();

        $Conditions = [];

        if (request()->has('search')) {
            $Conditions[] = ['first_name', 'like', '%' . request('search') . '%'];
        }

        if (request()->has('speciality') && request('speciality') != 'all') {
            $Conditions[] = ['doctors.speciality', request('speciality')];
            $queryUsers->join('doctors', 'users.id', '=', 'doctors.user_id');
        }

        if (request()->has('role') && request('role') != 'all') {
            $Conditions[] = ['role_id', request('role')];
        }
        $queryUsers->where($Conditions);

        return view('admin.users.index', compact('user'))
                    ->with('queryUsers', $queryUsers->paginate(10));
    }
   
}
