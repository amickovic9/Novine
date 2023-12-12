<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorController extends Controller
{
    public function showCMS(){
        $categories = Auth::user()->categories;
        return view('editor.cms',['categories'=>$categories]);
    }
    public function showDrafts(Category $category){
        $drafts = $category->news()->where('draft',1)->get();
        return view('editor.drafts',['drafts'=>$drafts,'category'=>$category]);
    }
    public function showEditDraft(News $draft){
        if( in_array($draft->rubrika,Auth::user()->categories()->pluck('categories.id')->toArray())&&$draft->draft == 1){
        return view('editor.edit-draft',['draft'=>$draft]);
        }
        else {
            return redirect('/')->with('success','Mozete upravljati samo vasim draftovima');
        }
    }
    public function allowDraft(News $draft){
        if( in_array($draft->rubrika,Auth::user()->categories()->pluck('categories.id')->toArray())){
            $draft['draft']=0;
            $draft->update();
            return redirect("cms-editor/drafts/{$draft->rubrika}")->with('success','Uspesno ste odobrili clanak');
        }
        else{
            return redirect('/')->with('success','Mozete upravljati samo vasom rubrikom!');
        }
    }
    public function declineDraft(News $draft){
        if( in_array($draft->rubrika,Auth::user()->categories()->pluck('categories.id')->toArray())&&$draft->draft==1){
            $draft->delete();
            return redirect("cms-editor/drafts/{$draft->rubrika}")->with('success','Uspesno ste odbili clanak');
        }
        else{
            return redirect('/')->with('success','Mozete upravljati samo vasom rubrikom');
        }
    }
    public function updateDraft(News $draft , Request $request){
        if(in_array($draft->rubrika,Auth::user()->categories()->pluck('categories.id')->toArray())&&$draft->draft == 1){
            $fields = $request->validate([
                'tekst' => 'required',
                'naslov' => 'required',
                'rubrika' => 'required',
            ]);
            $draft->update($fields);
            return redirect("cms-editor/drafts/{$draft->rubrika}")->with('success','Uspesno ste izmenili draft!');
        }
        else{
            return redirect('/')->with('danger','Mozete upravljati samo vasom rubrikom');
        }
    }

    public function showArticles(Category $category){
        $articles= $category->news()->where('draft',0)->get();
        return view('editor.articles',['articles'=>$articles,'category'=>$category]);
    }
    public function showPostedArticles( News $article){
        if(in_array($article->rubrika,Auth::user()->categories()->pluck('categories.id')->toArray())&&$article->draft ==0){
            return view('editor.posted-articles',['article'=>$article]);
        }
        else  return redirect('/')->with('danger','Mozete upravljati samo vasom rubrikom');

    }
    public function updateArticle(News $article , Request $request){
        if(in_array($article->rubrika,Auth::user()->categories()->pluck('categories.id')->toArray())){
            $fields = $request->validate([
                'tekst' => 'required',
                'naslov' => 'required',
                'rubrika' => 'required',
            ]);
            $article->update($fields);
            return redirect("cms-editor/articles/{$article->rubrika}")->with('success','Uspesno ste izmenili clanak!');
        }
        else{
            return redirect('/')->with('danger','Mozete upravljati samo vasom rubrikom');
        }
    }
    public function hideArticle(News $article){
        if(in_array($article->rubrika,Auth::user()->categories()->pluck('categories.id')->toArray())){
            $article['draft'] = 1;
            $article->update();
            return redirect("/cms-editor/articles/{$article->rubrika}")->with('success','Uspesno ste prebacili clanak u draftove');
        }
        else return redirect('/')->with('danger','Mozete upravljati samo vasim rubrikama!');
    }
    

}
