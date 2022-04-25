<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function blog(Request $request){

    	return view("site.blog");
    }

    public function blogDetail(Request $request){

    	return view("site.blog-detail");
    }
}
