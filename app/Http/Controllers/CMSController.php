<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CMSController extends Controller
{
    public function showCMSScreen(){
        return view('cms.cms');
    }
    public function showCreatePostScreen(){
        return view('cms.create-post');
    }
}
