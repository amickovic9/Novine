<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;
use App\Models\Likes;
use App\Models\Gallery;
use App\Models\LikeDislikeComment;
use App\Models\Dislikes;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class NewsController extends Controller
{
    public function createPost(Request $request)
{
    $fields = $request->validate([
        'naslov' => 'required',
        'naslovna' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'tekst' => 'required',
        'rubrika' => 'required',
        'tagovi' => 'required',
        'files' =>'',
    ]);


    $fields['user_id'] = Auth::user()->id;
    $draft = News::create($fields);

    if ($request->hasFile('naslovna')) {
        $naslovnaSlika = $request->file('naslovna');
        $naslovnaIme = time() . '.' . $naslovnaSlika->getClientOriginalExtension();
        $naslovnaSlika->storeAs('public/naslovne', $naslovnaIme);
        $draft->update(['naslovna' => $naslovnaIme]);
    }

    if ($request->hasFile('files')) {
        $galerijaFajlovi = $request->file('files');

        foreach ($galerijaFajlovi as $file) {
            $imeFajla = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/gallery', $imeFajla);

            Gallery::create([
                'news_id' => $draft->id, 
                'photo_video' => $imeFajla
            ]);
        }
    }

    $tagNames = explode(' ', $fields['tagovi']);
    $tagIDs = [];

    foreach ($tagNames as $tagName) {
        $tag = Tag::firstOrCreate(['name' => $tagName]);
        $tagIDs[] = $tag->id;
    }

    $draft->tags()->sync($tagIDs);

    if (Auth::user()->role == 4) {
        return redirect('/cms')->with('success', 'Uspesno ste kreirali clanak');
    } else if (Auth::user()->role == 2) {
        return redirect('/cms-journalist')->with('success', 'Uspesno ste kreirali clanak');
    } else if (Auth::user()->role == 3) {
        return redirect('/cms-editor')->with('success', 'Uspesno ste kreirali clanak');
    }
}


    public function showArticle(News $article)
    {
        
            $address = request()->ip();
            
            $like = Likes::where('ip_address', $address)
                ->where('article_id', $article->id)
                ->first();
    
            $likedArticle = $like ? true : false; 
    
            $query = Likes::query();
            $likeCountArticle = $query->where('article_id', $article->id)->count();
    
            $dislike = Dislikes::where('ip_address', $address)
                ->where('article_id', $article->id)
                ->first();
    
            $dislikedArticle = $dislike ? true : false;
    
            $dislikeCountArticle = Dislikes::where('article_id', $article->id)->count();
            
            $comments = $article->comments()->get();
            foreach ($comments as $comment) {
                $like = LikeDislikeComment::where('ip_address', $address)
                    ->where('comment_id', $comment->id)
                    ->where('like', true)
                    ->first();
                $likedComm = $like ? true : false;
                $likeCount = LikeDislikeComment::where('comment_id', $comment->id)
                    ->where('like', true)
                    ->count();
            
                $dislike = LikeDislikeComment::where('ip_address', $address)
                    ->where('comment_id', $comment->id)
                    ->where('dislike', true)
                    ->first();
                $dislikedComm = $dislike ? true : false;
                $dislikeCount = LikeDislikeComment::where('comment_id', $comment->id)
                    ->where('dislike', true)
                    ->count();
                
                $comment->liked = $likedComm;
                $comment->likeCount = $likeCount;
                $comment->disliked = $dislikedComm;
                $comment->dislikeCount = $dislikeCount;
            }
            return view('article', [
                'article' => $article,
                'comments' => $comments,
                'liked' => $likedArticle,
                'likeCount' => $likeCountArticle,
                'disliked' => $dislikedArticle,
                'dislikeCount' => $dislikeCountArticle
            ]);
        
    }
    

    public function likeArticle(Request $request, News $article)
{
    $ipAddress = $request->ip();

    $existingLike = Likes::where('ip_address', $ipAddress)
        ->where('article_id', $article->id)
        ->first();

    if ($existingLike) {
        $existingLike->delete();
    } else {
        $existingDislike = Dislikes::where('ip_address', $ipAddress)
            ->where('article_id', $article->id)
            ->first();

        if ($existingDislike) {
            $existingDislike->delete();
        }

        $fields['ip_address'] = $ipAddress;
        $fields['article_id'] = $article->id;
        Likes::create($fields);
    }

    return back();
}

public function dislikeArticle(Request $request, News $article)
{
    $ipAddress = $request->ip();

    $existingDislike = Dislikes::where('ip_address', $ipAddress)
        ->where('article_id', $article->id)
        ->first();

    if ($existingDislike) {
        $existingDislike->delete();
    } else {
        $existingLike = Likes::where('ip_address', $ipAddress)
            ->where('article_id', $article->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
        }

        $fields['ip_address'] = $ipAddress;
        $fields['article_id'] = $article->id;
        Dislikes::create($fields);
    }

    return back();
}

public function removeLikeArticle(Request $request, News $article)
{
    $ipAddress = $request->ip();
    $existingLike = Likes::where('article_id', $article->id)->where('ip_address', $ipAddress)->first();
    if ($existingLike) {
        $existingLike->delete();
    }
    return back();
}

public function removeDislikeArticle(Request $request, News $article)
{
    $ipAddress = $request->ip();
    $existingDislike = Dislikes::where('article_id', $article->id)->where('ip_address', $ipAddress)->first();
    if ($existingDislike) {
        $existingDislike->delete();
    }
    return back();
}
}
