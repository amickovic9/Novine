<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TextFormattingService;

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
        return redirect('/login')->with('success', 'Uspesno ste se registrovali!');
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

        if ($request->filled('naslov')) {
            $query->where('naslov', 'like', '%' . $request['naslov'] . '%');
        }

        if ($request->filled('datum')) {
            $query->whereDate('created_at', $request['datum']);
        }

        if ($request->filled('tagovi')) {
            $tagovi = explode(' ', $request->input('tagovi'));

            $query->whereHas('tags', function ($q) use ($tagovi) {
                $q->whereIn('name', $tagovi);
            });
        }

        if ($request->filled('rubrika')) {
            $query->where('rubrika', 'like', $request['rubrika']);
        }

        $news = $query->get();
        return view('home', ['news' => $news, 'categories' => $categories]);
    }
    public function showArticle(News $article)
    {

        return view('article.show', ['article' => $article]);
    }
}
