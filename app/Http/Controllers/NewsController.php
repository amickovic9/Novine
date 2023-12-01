<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function createPost(Request $request){
        $fields = $request->validate([
            'naslov' => 'required',
            'tekst' => 'required',
            'rubrika' => 'required',
        ]);
        News::create($fields);
        return redirect('/cms')->with('success','Uspesno ste kreirali clanak');
    }
}
