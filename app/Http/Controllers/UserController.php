<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\DeclareDeclare;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return view('my-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::id();
        $user = User::findOrFail($id);
        $user->fill($request->all());
        if ($request->hasFile('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload'), $image);
            $user->image = 'upload/' . $image;
        }
        $user->save();
        return redirect()->route('me.profile');
    }

    public function getListHouseOfUser() {
        $userLogin = Auth::user();
        $houses = $userLogin->house;
        dd($houses);
    }
}
