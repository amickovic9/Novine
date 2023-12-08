<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
    public function showNovinar(){
        
    }
    public function showCategories(){
        $categories = Category::all();
        return view('cms.categories',['categories' => $categories]);
    }
    public function addCategory(Request $request){
        $field = $request->validate([
            'category' => 'required',
        ]);
        Category::create($field);
        return back()->with('success','Uspesno ste dodali novu rubriku!');
    }
    public function editCategory(Category $category, Request $request){
        $field= $request->validate([
            'nameOfCategory' =>'required',
        ]);
        $fields['category'] = $field['nameOfCategory'];;
        $category->update($fields);
        return back()->with('success','Uspesno ste izmenili naziv rubrike!');
    }
    public function deleteCategory(Category $category){
        $category->delete();
        return back()->with('success','Uspesno ste izbrisali rubriku!');
    }
}
