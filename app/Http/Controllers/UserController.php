<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showLoginPage(){
        return view('login');
    }
    public function registerUser(Request $request){
        $fields = $request->validate([
            'fullname' => 'required',
            'reg_email' => 'required',
            'reg_password' => 'required',
        ]);
        $fields['password'] = bcrypt($fields['reg_password']);
        $fields['name'] = $fields['fullname'];
        $fields['email'] = $fields['reg_email'];
        User::create($fields);
        return redirect('/login')->with('success','Uspesno ste se registrovali!');
    }

    public function loginUser(Request $request){
        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if(auth()->attempt(['email' => $fields['email'], 'password' => $fields['password']])){
            $request->session()->regenerate();
            return redirect('/');
        }
        else{
            return redirect('/login')->with('danger', 'Pogresan email ili password!');
        }
    }

    public function logoutUser(){
        Auth::logout();
        return redirect('/');
    }
}
