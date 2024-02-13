<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;
use App\Models\User;
use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Models\UserCategories;
use App\Models\Users_categories;
use App\Models\ArticleEditRequests;
use App\Models\ArticleDeleteRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CMSController extends Controller
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

        if($article->likes()->exists()){
            $article->likes()->delete();
        }
        if($article->dislikes()->exists()){
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
    public function showCMSScreen(Request $request)
    {
        $query = User::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request['name'] . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request['email'] . '%');
        }
        if ($request->filled('role')) {
            $query->where('role', 'like', '%' . $request['role'] . '%');
        }
        $categories = Category::all();
        $users = $query->get();


        $query = News::query();
        if ($request->filled('naslov')) {
            $query->where('naslov', 'like', '%' . $request['naslov'] . '%');
        }
        
        if ($request->filled('rubrika')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->input('rubrika'));
            });
        }
        $posts = $query->orderBy('created_at', 'desc')->get();
        $categories=Category::all();
        return view('cms.cms', [
            'users' => $users,
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }
    public function showCreatePostScreen()
    {
        $categories = Category::all();
        return view('cms.create-post', ['categories' => $categories]);
    }

    public function showEditUser(User $user)
    {
        return view('cms.edit-user', ['user' => $user]);
    }
    public function editUser(User $user, Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);
        $user->update($fields);
        return redirect('cms')->with('success', 'Uspesno ste izmenili korisnika');
    }
    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('succes', 'Uspesno ste izbrisali korisnika!');
    }



    public function showCategories(Request $request)
    {
        $category = Category::query();
        if ($request->filled('name')) {
            $category->where('category', 'like', '%' . $request['name'] . '%');
        }
        $categories = $category->get();
        return view('cms.categories', ['categories' => $categories]);
    }
    public function addCategory(Request $request)
{
    try {
        $field = $request->validate([
            'category' => 'required|unique:categories',
        ]);
        
        Category::create($field);
        
        return back()->with('success', 'Uspesno ste dodali novu rubriku!');
    } catch (\Exception $e) {
        return back()->with('danger', 'Kategorija sa tim imenom vec postoji! ');
    }
}

    public function editCategory(Category $category, Request $request)
    {
        $field = $request->validate([
            'nameOfCategory' => 'required',
        ]);
        $fields['category'] = $field['nameOfCategory'];;
        $category->update($fields);
        return back()->with('success', 'Uspesno ste izmenili naziv rubrike!');
    }
    public function deleteCategory(Category $category)
    {
        $category->users()->detach();
        foreach ($category->news as $article) {
            $this->deleteArticle($article);
        }
        $category->delete();
        return back()->with('success', 'Uspesno ste izbrisali rubriku!');
    }
    public function removeCategoryFromJournalist(Request $request)
    {
        $id = $request->input('userCategoryId');
        $userCategory = Users_categories::find($id);
        $userCategory->delete();
        return back()->with('success', 'Uspesno ste uklonili korisnika sa date rubrike');
    }
    public function showUpdateEJ(User $user)
    {
        $allCategories = Category::all();
        $userCategories = Users_categories::where('user_id', $user->id)->pluck('category_id')->toArray();
        return view('cms.edit-journalist', [
            'journalist' => $user,
            'allCategories' => $allCategories,
            'userCategories' => $userCategories,
        ]);
    }


    public function updateCategoriesEJ(User $user, Request $request)
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

        return redirect('/cms')->with('success', 'Uspesno ste azurirali kategorije');
    }
    public function showEditors(Request $request)
    {

        $query = User::query()
            ->where('role', 'like', '3');
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request['name'] . '%');
        }
        $editors = $query->get();
        return view('cms.editors', ['editors' => $editors]);
    }
    public function showDeleteRequests(Request $request)
    {
        $search = $request->input('search');

        $deleteRequests = ArticleDeleteRequest::query();


        if ($search) {
            $deleteRequests->whereHas('news', function ($query) use ($search) {
                $query->where('naslov', 'LIKE', '%' . $search . '%');
            });
        }

        $deleteRequests = $deleteRequests->get();

        return view('CMS.delete-requests', compact('deleteRequests'));
    }

    public function allowDeleteRequest(ArticleDeleteRequest $deleteRequest)
    {
        $article = $deleteRequest->news;
        $this->deleteArticle($article);
        return back()->with("success", 'Uspesno ste odobrili brisanje clanka!');
    }
    public function declineDeleteRequest(ArticleDeleteRequest $deleteRequest)
    {
        $deleteRequest->delete();
        return back()->with("success", 'Uspesno ste odbili brisanje clanka!');
    }
    public function showEditRequests(Request $request)
    {
        $search = $request->input('search');

        $editRequests = ArticleEditRequests::query();


        if ($search) {
            $editRequests->whereHas('news', function ($query) use ($search) {
                $query->where('naslov', 'LIKE', '%' . $search . '%');
            });
        }

        $editRequests = $editRequests->get();
        return view('CMS.edit-requests', compact('editRequests'));
    }
    public function allowEditRequest(ArticleEditRequests $editRequest)
    {
        $article = $editRequest->news;
    
        
            if ($editRequest->naslovna != null) {
                $oldImagePath = storage_path('app/public/naslovne/' . $article->naslovna);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }else{
                $editRequest->naslovna= $article->naslovna;

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

    public function declineEditRequest(ArticleEditRequests $editRequest)
    {
        $editRequest->tags()->detach();
        $editRequest->delete();
        return back()->with('success', 'Odbili ste izmenu clanka!');
    }

    public function delArticle(News $article)
    {
        $this->deleteArticle($article);
        return back()->with('success', 'Uspesno ste izbrisali clanak!');
    }
    public function returnToDraft(News $article)
    {
        $article['draft'] = 1;
        $article->update();
        return back()->with('success', 'Uspesno ste vratili clanak u draft!');
    }
    public function showEditArticle(News $article)
    {
        $categories = Category::all();
        return view('journalist.edit-post', compact('article', 'categories'));
    }
    public function updateArticle(Request $request, News $article)
    {
        
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
            if ($request->hasFile('files')) {
                foreach ($article->gallery as $item) {
                    Storage::delete('public/gallery/' . $item->photo_video);
                    $item->delete();
                }
    
                foreach ($request->file('files') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/gallery', $filename);
    
                    $article->gallery()->create([
                        'photo_video' => $filename
                    ]);
                }
            }
            $article->tags()->sync($tagIDs);
            return redirect('/cms#table-article')->with('success', 'Uspesno ste izmenili clanak!');
    }

    public function deleteDraft(News $draft)
    {
        $draft->tags()->detach();
        $draft->delete();
        return redirect('/cms/drafts')->with('success', 'Uspesno ste izbrisali draft!');
    }

    public function showEditArticleScreen(News $article)
    {
        $categories = Category::all();
        return view('journalist.edit-post', compact('article', 'categories'));
    }
    public function showCreateUser(){
        return view('cms.create-user');
    }
    public function allowDraft(News $draft){
        $draft['draft']=0;
        $draft->update();
        return redirect('/cms')->with('success','Uspesno ste prebacili draft u clanke!');
    }
}
