<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function showProfile(){
        $user = Auth::user();
        if(!$user){
            return redirect()->route('login.show');
        }
        return Inertia::render('Profile/Profile', ['user'=>$user]);
    }

    public function showEditProfile(){
        return Inertia::render('Profile/Edit',['user'=>Auth::user()]);
    }

    public function storeEditProfile(Request $request){
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required'],
            'description' => 'max:10000'
        ]);
        $user = Auth::user();
        if($user->name === $request->name && $user->email === $request->email && $user->description === $request->description){

        }else{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->description = $request->description ?? '';
            $user->save();
        }
        return redirect()->route('profile.show');
    }

    public function showChangePass(){
        return Inertia::render('Profile/ChangePassword');
    }

    public function delete(){
        $user = Auth::user();
        if($user){
            Auth::logout();
            User::destroy($user->id);
            return redirect()->route('login.show');
        }else{
            return redirect()->route('login.show');
        }
    }
}
