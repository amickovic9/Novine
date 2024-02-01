<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;
use App\Models\Category;

use Illuminate\Http\Request;
use App\Models\ArticleEditRequests;

use App\Models\ArticleDeleteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\Facades\Storage;

class JournalistController extends Controller
{
    public function showCMS(Request $request)
    {
        $user_id = Auth::user()->id;
        $query = News::where('user_id', $user_id);

        if ($request->has('naslov')) {
            $query->where('naslov', 'like', '%' . $request->input('naslov') . '%');
        }

        if ($request->has('rubrika')) {
            $categoryName = $request->input('rubrika');
            $categoryId = Category::where('category', $categoryName)->value('id');

            if ($categoryId) {
                $query->where('rubrika', $categoryId);
            }
        }

        if ($request->has('draft') && $request->input('draft') != '') {
            $query->where('draft', $request->input('draft'));
        }

        $articles = $query->orderBy('created_at', 'desc')->get();

        foreach ($articles as $article) {
            $deleteRequestSent = !is_null($article->deleteRequest);
            $updateRequestSent = !is_null($article->editRequest);
            $article['deleteRequestSent'] = $deleteRequestSent;
            $article['updateRequestSent'] = $updateRequestSent;
        }

        return view('journalist.cms', ['articles' => $articles]);
    }

    public function showDrafts()
    {
        $user = Auth::user();
        $drafts = $user->news()->where('draft', '1')->get();
        return view('journalist.drafts', ['drafts' => $drafts]);
    }
    public function showCreatePost()
    {
        $categories = Auth::user()->categories;
        return view('journalist.create-post', ['categories' => $categories]);
    }
    public function deletePost(News $article)
    {
        if ($article->user_id == Auth::user()->id && $article->draft == 1) {
            if ($article->naslovna != null) {
                $oldImagePath = storage_path('app/public/naslovne/' . $article->naslovna);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $article->tags()->detach();
            $article->delete();
            return redirect('/cms-journalist/drafts')->with('success', 'Uspesno ste izbrisali draft!');
        } else {
            return redirect('/')->with('success', 'Mozete upravljati samo vasim draftovima!');
        }
    }
    public function showEditPost(News $article)
    {
        $categories = Auth::user()->categories;
        if ($article->user_id == Auth::user()->id && $article->draft == 1) {
            return view('journalist.edit-post', ['article' => $article, 'categories' => $categories]);
        } else return redirect('/')->with('success', 'Mozete upravljati samo vasim draftovima!');
    }
    public function editPost(News $article, Request $request)
    {
        if (Auth::user()->id == $article->user_id && $article->draft == 1) {
            $fields = $request->validate([
                'naslov' => 'required',
                'naslovna' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

                'tekst' => 'required',
                'rubrika' => 'required',
                'tag' => 'required'
            ]);
            if ($request->hasFile('naslovna')) {
                $oldImagePath = storage_path('app/public/naslovne/' . $article->naslovna);

                Storage::delete('naslovne/' . $article->naslovna);

                if (Storage::missing('naslovne/' . $article->naslovna) && File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }

                $naslovna = $request->file('naslovna');
                $naslovnaIme = time() . '.' . $naslovna->getClientOriginalExtension();
                $naslovna->storeAs('public/naslovne', $naslovnaIme);
                $fields['naslovna'] = $naslovnaIme;
            }
            $article->update($fields);
            $article->tags()->detach();
            $tagNames = explode(' ', $fields['tag']);

            $tagIDs = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIDs[] = $tag->id;
            }
            $article->tags()->sync($tagIDs);
            return redirect('/cms-journalist')->with('success', 'Uspesno ste izmenili draft!');
        } else {
            return redirect('/cms-journalist')->with('success', 'Mozete izmeniti samo vase draftove!');
        }
    }
    public function showMyArticles()
    {
        $user_id = Auth::user()->id;
        $articles = News::query()->where('user_id', "$user_id")->where('draft', 0)->get();
        return view('journalist.my-articles', ['articles' => $articles]);
    }
    public function articleCheck(News $article)
    {
        if (Auth::check()) {
            if (Auth::user()->id == $article->user_id) {
                return true;
            }
        } else {
            return redirect('/')->with('danger', 'Mozete upraljati samo vasim clancima');
        }
    }
    public function showArticle(News $article)
    {
        if ($this->articleCheck($article)) {
            $categories = Auth::user()->categories;
            $deleteRequestSent = !is_null($article->deleteRequest);
            $updateRequestSent = !is_null($article->editRequest);
            $tags = $article->tags->pluck('name');

            return view('journalist.article', [
                'article' => $article,
                'updateRequestSent' => $updateRequestSent,
                'categories' => $categories,
                'tags' => $tags
            ]);
        }
    }


    public function requestDelete(News $article)
    {
        if ($this->articleCheck($article)) {
            $field['article_id'] = $article->id;
            $field['category_id'] = $article->rubrika;
            ArticleDeleteRequest::create($field);
            return redirect("/cms-journalist")->with('success', 'Uspesno ste poslali zahtev za brisanje clanka!');
        }
    }
    public function requestUpdate(News $article, Request $request)
    {
        if ($this->articleCheck($article)) {
            $fields = $request->validate([
                'tekst' => 'required',
                'naslovna' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'naslov' => 'required',
                'rubrika' => 'required',
                'tags' => 'required',
            ]);
            if ($request->hasFile('naslovna')) {
                $naslovna = $request->file('naslovna');
                $naslovnaIme = time() . '.' . $naslovna->getClientOriginalExtension();
                $naslovna->storeAs('public/naslovne', $naslovnaIme);
                $fields['naslovna'] = $naslovnaIme;
            }
            $fields['article_id'] = $article->id;
            $fields['category_id'] = $article->rubrika;
            $articleEditRequest = ArticleEditRequests::create($fields);
            $tagNames = explode(' ', $fields['tags']);

            $tagIDs = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIDs[] = $tag->id;
            }

            $articleEditRequest->tags()->sync($tagIDs);
            return redirect("/cms-journalist")->with('success', 'Uspesno ste poslali zahtev za izmenu clanka!');
        }
    }
}
