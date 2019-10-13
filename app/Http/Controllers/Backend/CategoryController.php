<?php

namespace App\Http\Controllers\Backend;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    function getCategory()
    {
        $data['categories']=category::all()->toArray();
        return view('backend.category.category',$data);
    }
    
    function getEditIndex()
    {
        return view('backend.category.editcategory');
    }

    function postCategory(AddCategoryRequest $r){
        dd($r->all());
    }
}
