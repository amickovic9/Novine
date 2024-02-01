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
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    public function deleteArticle(News $article)
    {

        if ($article->comments()->exists()) {
            $article->comments()->delete();
        }



        if ($article->deleteRequest()->exists()) {
            $article->deleteRequest()->delete();
        }

        if ($article->editRequest()->exists()) {
            $article->editRequest()->delete();
        }

        if ($article->tags()->exists()) {
            $article->tags()->detach();
        }

        if ($article->likes()->exists()) {
            $article->likes()->delete();
        }
        if ($article->naslovna != null) {
            $oldImagePath = storage_path('app/public/naslovne/' . $article->naslovna);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $article->delete();
    }
    public function showCMS()
    {
        $user = Auth::user();
        $categories = $user->categories;
        $categoryIds = $categories->pluck('id')->toArray();
        $updateRequest = ArticleEditRequests::whereIn('category_id', $categoryIds)->count();
        $deleteRequestsCount = ArticleDeleteRequest::whereIn('category_id', $categoryIds)->count();

        return view('editor.cms', [
            'categories' => $categories,
            'deleteRequests' => $deleteRequestsCount,
            'updateRequests' => $updateRequest,
        ]);
    }

    public function showDrafts(Category $category)
    {
        $drafts = $category->news()->where('draft', 1)->get();
        return view('editor.drafts', ['drafts' => $drafts, 'category' => $category]);
    }
    public function showEditDraft(News $draft)
    {
        if (in_array($draft->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray()) && $draft->draft == 1) {
            return view('editor.edit-draft', ['draft' => $draft]);
        } else {
            return redirect('/')->with('success', 'Mozete upravljati samo vasim draftovima');
        }
    }
    public function allowDraft(News $draft)
    {
        if (in_array($draft->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray())) {
            $draft['draft'] = 0;
            $draft->update();
            return redirect("cms-editor/drafts/{$draft->rubrika}")->with('success', 'Uspesno ste odobrili clanak');
        } else {
            return redirect('/')->with('success', 'Mozete upravljati samo vasom rubrikom!');
        }
    }
    public function declineDraft(News $draft)
    {
        if (in_array($draft->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray()) && $draft->draft == 1) {
            $this->deleteArticle($draft);

            return redirect("cms-editor/drafts/{$draft->rubrika}")->with('success', 'Uspesno ste odbili clanak');
        } else {
            return redirect('/')->with('success', 'Mozete upravljati samo vasom rubrikom');
        }
    }
    public function updateDraft(News $draft, Request $request)
    {
        if (in_array($draft->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray()) && $draft->draft == 1) {
            $fields = $request->validate([
                'tekst' => 'required',
                'naslovna' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

                'naslov' => 'required',
                'rubrika' => 'required',
                'tags' => 'required'
            ]);
            if ($request->hasFile('naslovna')) {
                $oldImagePath = storage_path('app/public/naslovne/' . $draft->naslovna);

                Storage::delete('naslovne/' . $draft->naslovna);

                if (Storage::missing('naslovne/' . $draft->naslovna) && File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }

                $naslovna = $request->file('naslovna');
                $naslovnaIme = time() . '.' . $naslovna->getClientOriginalExtension();
                $naslovna->storeAs('public/naslovne', $naslovnaIme);
                $fields['naslovna'] = $naslovnaIme;
            }
            $draft->update($fields);
            $draft->tags()->detach();
            $tagNames = explode(' ', $fields['tags']);

            $tagIDs = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIDs[] = $tag->id;
            }
            $draft->tags()->sync($tagIDs);
            return redirect("cms-editor/drafts/{$draft->rubrika}")->with('success', 'Uspesno ste izmenili draft!');
        } else {
            return redirect('/')->with('danger', 'Mozete upravljati samo vasom rubrikom');
        }
    }

    public function showArticles(Category $category)
    {
        $articles = $category->news()->where('draft', 0)->get();
        return view('editor.articles', ['articles' => $articles, 'category' => $category]);
    }
    public function showPostedArticles(News $article)
    {
        if (in_array($article->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray()) && $article->draft == 0) {
            return view('editor.posted-articles', ['article' => $article]);
        } else  return redirect('/')->with('danger', 'Mozete upravljati samo vasom rubrikom');
    }
    public function updateArticle(News $article, Request $request)
    {
        if (in_array($article->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray())) {
            $fields = $request->validate([
                'tekst' => 'required',
                'naslovna' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'naslov' => 'required',
                'rubrika' => 'required',
                'tags' => 'required'
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
            $tagNames = explode(' ', $fields['tags']);

            $tagIDs = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIDs[] = $tag->id;
            }
            $article->tags()->sync($tagIDs);
            return redirect("cms-editor/articles/{$article->rubrika}")->with('success', 'Uspesno ste izmenili clanak!');
        } else {
            return redirect('/')->with('danger', 'Mozete upravljati samo vasom rubrikom');
        }
    }
    public function hideArticle(News $article)
    {
        if ($this->articleCheck($article)) {
            $article['draft'] = 1;
            $article->update();
            if ($article->editRequest()->exists()) {
                $article->editRequest->delete();
            }
            if ($article->deleteRequest()->exists()) {
                $article->deleteRequest->delete();
            }
            return redirect("/cms-editor/articles/{$article->rubrika}")->with('success', 'Uspesno ste prebacili clanak u draftove');
        } else return redirect('/')->with('danger', 'Mozete upravljati samo vasim rubrikama!');
    }
    public function showDeleteRequests()
    {
        $user = Auth::user();
        $categoryIds = $user->categories()->pluck('categories.id')->toArray();
        $deleteRequests = ArticleDeleteRequest::whereIn('category_id', $categoryIds)->get();
        return view('editor.delete-requests', ['deleteRequests' => $deleteRequests]);
    }
    public function articleCheck(News $article)
    {
        if (Auth::check()) {
            $categories = Auth::user()->categories()->pluck('categories.id')->toArray();
            if (in_array($article->rubrika, $categories)) {
                return true;
            }
        } else {
            return redirect('/')->with('danger', 'Mozete upraljati samo vasim rubrikama');
        }
        return false;
    }
    public function allowDeleteRequest(ArticleDeleteRequest $deleteRequest)
    {
        $article = $deleteRequest->news;

        if ($this->articleCheck($article)) {
            $this->deleteArticle($article);

            return back()->with('success', 'Uspešno ste odobrili brisanje članka!');
        }
    }
    public function declineDeleteRequest(ArticleDeleteRequest $deleteRequest)
    {
        $article = $deleteRequest->news;
        if ($this->articleCheck($article)) {
            $deleteRequest->delete();
            return back()->with('success', 'Uspešno ste odbili brisanje članka!');
        }
    }
    public function showEditRequests()
    {
        $user = Auth::user();
        $categoryIds = $user->categories()->pluck('categories.id')->toArray();
        $editRequests = ArticleEditRequests::whereIn('category_id', $categoryIds)->get();
        return view('editor.edit-requests', ['editRequests' => $editRequests]);
    }

    public function allowEdit(ArticleEditRequests $editRequest)
    {
        $article = $editRequest->news;
        if ($this->articleCheck($article)) {
            if ($editRequest['naslovna'] != null) {
                $filePath = storage_path('app/public/naslovne/' . $article->naslovna);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $article['naslovna'] = $editRequest['naslovna'];
            } else {
                $editRequest['naslovna'] = $article['naslovna'];
            }
            $article->update($editRequest->toArray());
            $tags = $editRequest->tags;
            $article->tags()->detach();
            $article->tags()->sync($tags);
            $editRequest->tags()->detach();

            $editRequest->delete();
            return back()->with('success', 'Uspesno ste odobrili izmenu clanka!');
        }
    }
    public function declineEdit(ArticleEditRequests $editRequest)
    {
        $article = $editRequest->news;
        if ($this->articleCheck($article)) {
            $editRequest->tags()->detach();
            if ($editRequest['naslovna'] != null) {
                $filePath = storage_path('app/public/naslovne/' . $editRequest->naslovna);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $editRequest->delete();
            return back()->with('success', 'Uspesno ste odbili izmenu clanka!');
        }
    }
}
