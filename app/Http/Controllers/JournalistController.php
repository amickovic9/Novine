<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\ArticleEditRequests;
use App\Models\ArticleDeleteRequest;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;

class JournalistController extends Controller
{
    public function showCMS()
    {
        return view('journalist.cms');
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
                'tekst' => 'required',
                'rubrika' => 'required',
                'tag' => 'required'
            ]);
            $article->update($fields);
            $article->tags()->detach();
            $tagNames = explode(' ', $fields['tag']);

            $tagIDs = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIDs[] = $tag->id;
            }
            $article->tags()->sync($tagIDs);
            return redirect('/cms-journalist/drafts')->with('success', 'Uspesno ste izmenili draft!');
        } else {
            return redirect('/cms-journalist/drafts')->with('success', 'Mozete izmeniti samo vase draftove!');
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
                'deleteRequestSent' => $deleteRequestSent,
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
            return redirect("/cms-journalist/article/{$article->id}")->with('success', 'Uspesno ste poslali zahtev za brisanje clanka!');
        }
    }
    public function requestUpdate(News $article, Request $request)
    {
        if ($this->articleCheck($article)) {
            $fields = $request->validate([
                'tekst' => 'required',
                'naslov' => 'required',
                'rubrika' => 'required',
                'tags' => 'required',
            ]);
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
            return redirect("/cms-journalist/article/{$article->id}")->with('success', 'Uspesno ste poslali zahtev za izmenu clanka!');
        }
    }
}
