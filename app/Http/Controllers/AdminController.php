<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAdminRequest;
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

    public function updateProfile(UpdateAdminRequest $request)
    {
        $user = auth()->user();
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $validatedData['image'] = $imagePath;
        }
        /**
         * @var User $user
         */
        $user->update($validatedData);

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully');
    }


}