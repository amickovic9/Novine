<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;
use App\Models\User;
use App\Models\Category;
use App\Models\Gallery;
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
            $comments = $article->comments()->get();

            foreach ($comments as $comment) {
                $comment->likesDislikes()->delete();
            }
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
        if ($article->dislikes()->exists()) {
            $article->dislikes()->delete();
        }


        if ($article->naslovna != null) {
            $oldImagePath = storage_path('app/public/naslovne/' . $article->naslovna);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }


        foreach ($article->gallery as $galleryItem) {
            $imagePath = storage_path('app/public/gallery/' . $galleryItem->photo_video);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $galleryItem->delete();
        }
        $article->delete();
    }
    public function deleteAr(News $article)
    {
        $this->deleteArticle($article);
        return redirect('/cms-editor')->with('success', 'Uspesno ste izbrisali objavu');
    }
    public function showCMS(Request $request)
    {
        $user = Auth::user();
        $categories = $user->categories;
        $categoryIds = $categories->pluck('id')->toArray();
        $updateRequest = ArticleEditRequests::whereIn('category_id', $categoryIds)->count();
        $deleteRequestsCount = ArticleDeleteRequest::whereIn('category_id', $categoryIds)->count();
        $searchName = $request->input('name');
        $searchEmail = $request->input('email');
        $journalistsQuery = User::where('role', 2);
        if ($request->has('name')) {
            $journalistsQuery->where('name', 'like', '%' . $searchName . '%');
        }
        if ($request->has('email')) {
            $journalistsQuery->where('email', 'like', '%' . $searchEmail . '%');
        }
        $journalists = $journalistsQuery->paginate(10);

        $rubrika = $request->input('rubrika');
        $naslov = $request->input('naslov');
        $draft = $request->input('draft');
        $articlesQuery = News::whereIn('rubrika', $categoryIds)->orderBy('created_at', 'desc');
        if (!empty($naslov)) {
            $articlesQuery->where('naslov', 'like', '%' . $naslov . '%');
        }
        if (!empty($rubrika)) {
            $articlesQuery->where('rubrika', $rubrika);
        }
        if (!is_null($draft)) {
            $articlesQuery->where('draft', $draft);
        }
        $articles = $articlesQuery->paginate(10);

        foreach ($journalists as $journalist) {
            $journalistCategories = $journalist->categories;
            $journalistCategoryIds = $journalistCategories->pluck('id')->toArray();
            $journalist['categoryIds'] = $journalistCategoryIds;
        }

        return view('editor.cms', [
            'categories' => $categories,
            'articles' => $articles,
            'deleteRequests' => $deleteRequestsCount,
            'updateRequests' => $updateRequest,
            'journalists' => $journalists,
        ]);
    }


    public function showEditDraft(News $draft)
    {
        if (in_array($draft->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray()) && $draft->draft == 1) {
            $categories = Auth::user()->categories;
            return view('editor.edit-draft', ['draft' => $draft, 'categories' => $categories]);
        } else {
            return redirect('/')->with('success', 'Mozete upravljati samo vasim draftovima');
        }
    }
    public function allowDraft(News $draft)
    {
        if (in_array($draft->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray())) {
            $draft['draft'] = 0;
            $draft->update();
            return redirect("/cms-editor")->with('success', 'Uspesno ste odobrili clanak');
        } else {
            return redirect('/')->with('success', 'Mozete upravljati samo vasom rubrikom!');
        }
    }
    public function declineDraft(News $draft)
    {
        if (in_array($draft->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray()) && $draft->draft == 1) {
            $this->deleteArticle($draft);

            return redirect("/cms-editor")->with('success', 'Uspesno ste odbili clanak');
        } else {
            return redirect('/')->with('success', 'Mozete upravljati samo vasom rubrikom');
        }
    }
    public function updateDraft(News $draft, Request $request)
    {
        if (in_array($draft->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray())) {
            $fields = $request->validate([
                'tekst' => 'required',
                'naslovna' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'files' => '',
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
            if ($request->hasFile('files')) {
                foreach ($draft->gallery as $item) {
                    Storage::delete('public/gallery/' . $item->photo_video);
                    $item->delete();
                }

                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/gallery', $filename);

                    $draft->gallery()->create([
                        'photo_video' => $filename
                    ]);
                }
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
            return redirect("cms-editor")->with('success', 'Uspesno ste izmenili objavu!');
        } else {
            return redirect('/')->with('danger', 'Mozete upravljati samo vasom ruuuuubrikom');
        }
    }


    public function showPostedArticles(News $article)
    {
        if (in_array($article->rubrika, Auth::user()->categories()->pluck('categories.id')->toArray()) && $article->draft == 0) {
            $categories = Auth::user()->categories;

            return view('editor.posted-articles', ['article' => $article, 'categories' => $categories]);
        } else  return redirect('/')->with('danger', 'Mozete upravljati samo vasom rubrikom');
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
            return redirect("/cms-editor")->with('success', 'Uspesno ste prebacili clanak u draftove');
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
            if ($editRequest->naslovna != null) {
                $oldImagePath = storage_path('app/public/naslovne/' . $article->naslovna);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            } else {
                $editRequest->naslovna = $article->naslovna;
            }

            $article->gallery->each(function ($galleryItem) {
                $galleryImagePath = storage_path('app/public/gallery/' . $galleryItem->photo_video);
                if (file_exists($galleryImagePath)) {
                    unlink($galleryImagePath);
                }
                $galleryItem->delete();
            });

            if ($editRequest->gallery()->exists()) {
                $newGalleryItems = $editRequest->gallery()->get();
                foreach ($newGalleryItems as $newGalleryItem) {
                    Gallery::create([
                        'news_id' => $article->id,
                        'photo_video' => $newGalleryItem->photo_video
                    ]);
                }
            }

            $article->update($editRequest->toArray());

            $tags = $editRequest->tags;
            $article->tags()->sync($tags);

            $editRequest->tags()->detach();

            $editRequest->delete();

            return back()->with('success', 'Uspešno ste odobrili izmenu članka!');
        }
    }

    public function declineEdit(ArticleEditRequests $editRequest)
    {
        $article = $editRequest->news;

        if ($this->articleCheck($article)) {
            $editRequest->tags()->detach();

            if ($editRequest->naslovna != null) {
                $filePath = storage_path('app/public/naslovne/' . $editRequest->naslovna);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $editRequest->gallery->each(function ($galleryItem) {
                $galleryImagePath = storage_path('app/public/gallery/' . $galleryItem->photo_video);
                if (file_exists($galleryImagePath)) {
                    unlink($galleryImagePath);
                }
                $galleryItem->delete();
            });

            $editRequest->delete();

            return back()->with('success', 'Uspešno ste odbili izmenu članka!');
        }
    }

    public function updateCategories(User $user, Request $request)
    {
        $userCategories = $user->categories()->pluck('categories.id')->toArray();
        $newCategories = $request->input('categories');

        if (!is_array($newCategories)) {
            $newCategories = [];
        }

        $categoriesToRemove = array_diff($userCategories, $newCategories);
        $user->categories()->detach($categoriesToRemove);

        $categoriesToAdd = array_diff($newCategories, $userCategories);
        $user->categories()->attach($categoriesToAdd);
        return redirect('/cms-editor')->with('success', "Uspesno ste azurirali kategorije korisnika");
    }
    public function showCreate()
    {
        $categories = Auth::user()->categories;
        return view('editor.create-post', [
            'categories' => $categories
        ]);
    }
}
