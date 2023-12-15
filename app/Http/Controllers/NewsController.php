<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;
use App\Models\Likes;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class NewsController extends Controller
{
    public function createPost(Request $request){
            $fields = $request->validate([
        'naslov' => 'required',
        'tekst' => 'required',
        'rubrika' => 'required',
        'tagovi' => 'required'
    ]);

    $fields['user_id'] = Auth::user()->id;
    $draft = News::create($fields);

    $tagNames = explode(' ', $fields['tagovi']);

    // Kreiranje i sinhronizacija tagova
    $tagIDs = [];
    foreach ($tagNames as $tagName) {
        $tag = Tag::firstOrCreate(['name' => $tagName]);
        $tagIDs[] = $tag->id; 
    }

    $draft->tags()->sync($tagIDs);

    if(Auth::user()->role == 4){
        return redirect('/cms')->with('success','Uspesno ste kreirali clanak');
    } else if(Auth::user()->role == 2){
        return redirect('/cms-journalist/drafts')->with('success','Uspesno ste kreirali clanak');
    }
}

    public function checkArticle(News $article){
        if($article->draft == 0){
            return true;
        }
        return redirect('/');
    }
    public function showArticle(News $article){
        if($this->checkArticle($article)){
            $address = request()->ip();
            $like = Likes::where('ip_address', $address)
                        ->where('article_id', $article->id)
                        ->first();

            if ($like) {
                $liked = true;
            } else {
                $liked = false;
            }

            

            $comments = $article->comments()->get();
            return view('article', [
                'article' => $article,
                'comments' => $comments,
                'liked' => $liked,
            ]);
        }
    }



    public function like(News $article){
        if ($this->checkArticle($article)) {
            $address = request()->ip();

            $existingLike = Likes::where('ip_address', $address)
                                ->where('article_id', $article->id)
                                ->first();

            if (!$existingLike) {
                $fields['ip_address'] = $address;
                $fields['article_id'] = $article->id;
                Likes::create($fields);
            }
        }
        return back();
    }

    public function dislike(News $article){
        if($this->checkArticle($article)){
            $ip = request()->ip();
            $existingLike = Likes::where('article_id',$article->id)->where('ip_address',$ip)->first();
            if($existingLike){
                $existingLike->delete();
            }
            return back();
        }
    }
   
}
