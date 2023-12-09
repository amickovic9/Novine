<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\UserCategories;
use App\Models\Users_categories;
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
        $novinari = User::query()
            ->with('categories') 
            ->where('role', 'like', '2')
            ->get();
        return view('cms.novinari', ['novinari' => $novinari]);
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
        $category->users()->detach();
        $category->delete();
        return back()->with('success','Uspesno ste izbrisali rubriku!');
    }
    public function removeCategoryFromJournalist(Request $request){
        $id = $request->input('userCategoryId');
        $userCategory = Users_categories::find($id);
        $userCategory->delete();
        return back()->with('success','Uspesno ste uklonili korisnika sa date rubrike');
    }
    public function showUpdateEJ(User $user){
        $allCategories = Category::all(); 
        $userCategories = Users_categories::where('user_id', $user->id)->pluck('category_id')->toArray();
        return view('cms.edit-journalist', [
            'journalist' => $user,
            'allCategories' => $allCategories,
            'userCategories' => $userCategories,
        ]);
    }
    
   
    public function updateCategoriesEJ(User $user, Request $request) {
        $userCategories = $user->categories()->pluck('categories.id')->toArray();
        $newCategories = $request->input('categories');

        if (!is_array($newCategories)) {
            $newCategories = [];
        }

        $categoriesToRemove = array_diff($userCategories, $newCategories);
        $categoriesToAdd = array_diff($newCategories, $userCategories);
        $categoriesToRemove = array_diff($userCategories, $newCategories);
        $categoriesToAdd = array_diff($newCategories, $userCategories);

        if (!empty($categoriesToRemove)) {
            $user->categories()->detach($categoriesToRemove);
        }

        if (!empty($categoriesToAdd)) {
            $user->categories()->sync($categoriesToAdd);
        } elseif (empty($categoriesToAdd) && empty($newCategories)) {
            $user->categories()->detach(); // Ukloni sve kategorije ako nisu izabrane nove
        }

        if ($user->role == 2) {
            return redirect('/cms/journalist')->with('success', 'Kategorije su uspešno ažurirane.');
        } elseif ($user->role == 3) {
            return redirect('/cms/editors')->with('success', 'Kategorije su uspešno ažurirane.');
        }
    }


    public function showEditors(){
        $editors = User::query()
            ->where('role', 'like', '3')
            ->get();
        return view('cms.editors',['editors' =>$editors]);
    }


}
