<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function addComment(Request $request){
        $fields = $request ->validate([
            'user_name' => 'required',
            'article_id' => 'required',
            'comment' => 'required',
        ]);
        Comment::create($fields);
        return redirect("/article/{$fields['article_id']}")->with('success','Uspesno ste dodali komentar');
    }
}
