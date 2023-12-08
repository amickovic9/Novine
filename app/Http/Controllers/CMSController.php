<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    public function showCMSScreen(){
        return view('cms.cms');
    }
    public function showCreatePostScreen(){
        return view('cms.create-post');
    }
    public function showUsers(){
        $users = User::all();
        return view('cms.users',['users' => $users]);
    }
    public function showEditUser(User $user){
        return view('cms.edit-user',['user'=>$user]);
    }
    public function editUser(User $user,Request $request){
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);
        $user->update($fields);
        return redirect('cms/users')->with('success','Uspesno ste izmenili korisnika');
    }
    public function deleteUser(User $user){
        $user->delete();
        return back()->with('succes','Uspesno ste izbrisali korisnika!');
    }
}
