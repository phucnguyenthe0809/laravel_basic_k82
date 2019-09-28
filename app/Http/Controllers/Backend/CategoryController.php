<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function getCategory()
    {
        return view('backend.category.category');
    }
    
    function getEditIndex()
    {
        return view('backend.category.editcategory');
    }

    function postCategory(request $r){
        dd($r->all());
    }
}
