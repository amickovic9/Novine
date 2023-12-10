<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function createPost(Request $request){
        $fields = $request->validate([
            'naslov' => 'required',
            'tekst' => 'required',
            'rubrika' => 'required',
        ]);
        $fields['user_id'] = Auth::user()->id;
        News::create($fields);
        if(Auth::user()->role == 4){
            return redirect('/cms')->with('success','Uspesno ste kreirali clanak');
        }
        else if(Auth::user()->role == 2){
            return redirect('/cms-journalist/drafts')->with('success','Uspesno ste kreirali clanak');
        }
    }
    public function showArticle(News $article){
        return view('article',['article' => $article]);
    }
   
}
