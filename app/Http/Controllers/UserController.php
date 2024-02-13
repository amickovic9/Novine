<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use App\Models\LikeDislikeComment;

class UserController extends Controller
{
    public function showLoginPage()
    {
        return view('login');
    }

    public function registerUser(Request $request)
    {
        $fields = $request->validate([
            'fullname' => 'required',
            'reg_email' => 'required',
            'reg_password' => 'required',
        ]);
        $fields['password'] = bcrypt($fields['reg_password']);
        $fields['name'] = $fields['fullname'];
        $fields['email'] = $fields['reg_email'];
        User::create($fields);
        return redirect('/cms')->with('success', 'Uspesno ste registrovali novog korisnika!');
    }

    public function loginUser(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (auth()->attempt(['email' => $fields['email'], 'password' => $fields['password']])) {
            $request->session()->regenerate();
            return redirect('/');
        } else {
            return redirect('/login')->with('danger', 'Pogresan email ili password!');
        }
    }

    public function logoutUser()
    {
        Auth::logout();
        return redirect('/');
    }

    public function showHomePage(Request $request)
    {
        $categories = Category::all();
        $query = News::query()->where('draft', 0);

        if ($request->filled('pretraga')) {
            $pretraga = $request->input('pretraga');
            $query->where(function ($q) use ($pretraga) {
                $q->where('naslov', 'like', "%$pretraga%");

                $q->orWhereHas('category', function ($q) use ($pretraga) {
                    $q->where('category', 'like', "%$pretraga%");
                });

                $q->orWhereHas('tags', function ($q) use ($pretraga) {
                    $q->where('name', 'like', "%$pretraga%");
                });
            });
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('home', ['news' => $news, 'categories' => $categories]);
    }

    public function showArticle(News $article)
    {
        
        return view('article.show', ['article' => $article]);
    }

    public function showAbout()
    {
        return view('about');
    }

    public function likeComment(Comment $comment)
    {
        $ipAddress = request()->ip(); 
        $existingLike = LikeDislikeComment::where('comment_id', $comment->id)
            ->where('ip_address', $ipAddress)
            ->first();
    
        if ($existingLike) {
            if ($existingLike->like) {
                $existingLike->delete();
            } else {
                $existingLike->like = true;
                $existingLike->dislike = false;
                $existingLike->save();
            }
        } else {
            LikeDislikeComment::create([
                'comment_id' => $comment->id,
                'ip_address' => $ipAddress,
                'like' => true,
                'dislike' => false,
            ]);
        }
    
        return back();
    }
    
    public function dislikeComment(Comment $comment)
    {
        $ipAddress = request()->ip(); 
        $existingLike = LikeDislikeComment::where('comment_id', $comment->id)
            ->where('ip_address', $ipAddress)
            ->first();
    
        if ($existingLike) {
            if ($existingLike->dislike) {
                $existingLike->delete();
            } else {
                $existingLike->dislike = true;
                $existingLike->like = false;
                $existingLike->save();
            }
        } else {
            LikeDislikeComment::create([
                'comment_id' => $comment->id,
                'ip_address' => $ipAddress,
                'like' => false,
                'dislike' => true,
            ]);
        }
    
        return back();
    }
}    