<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalistController extends Controller
{
    public function showCMS(){
        return view('journalist.cms');
    }
    public function showDrafts(){
        $user = Auth::user();
        $drafts = $user->news()->where('draft','1')->get();
        return view('journalist.drafts',['drafts' =>$drafts ]);
    }
    public function showCreatePost(){
        return view('journalist.create-post');
    }
    public function deletePost(News $article){
        if($article->user_id == Auth::user()->id){
            $article->delete();
            return redirect('/cms-journalist/drafts')->with('success','Uspesno ste izbrisali draft!');
        }
        else {
            return redirect('/cms-journalist/drafts');
        }
    }
    public function showEditPost(News $article){
        if($article->user_id == Auth::user()->id){
        return view('journalist.edit-post',['article'=>$article]);
        }
    }
    public function editPost(News $article, Request $request){
        if(Auth::user()->id == $article->user_id){
            $fields = $request->validate([
            'naslov' => 'required',
            'tekst' => 'required',
            'rubrika' => 'required',
            ]);
            $article->update($fields);
            return redirect('/cms-journalist/drafts')->with('success','Uspesno ste izmenili draft!');
        }
        else{
            return redirect('/cms-journalist/drafts')->with('success','Mozete izmeniti samo vase draftove!');

        }
    }
}
