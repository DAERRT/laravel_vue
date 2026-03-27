<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function showProfile(){
        $user = Auth::user();
        if(!$user){
            return redirect()->route('login.show');
        }
        $articles = Article::where('author_id','=',$user->id)->get();
        return Inertia::render('Profile/Profile', ['user'=>$user,'articles'=>$articles]);
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

    public function storeChangePass(Request $request){
        $request -> validate([
            'password' => 'required|current_password',
            'newPassword' => 'required|confirmed|min:8|string',
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->newPassword);
        $user->save();
        Auth::logoutOtherDevices($request->newPassword);
        return redirect()->route('profile.show');
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
