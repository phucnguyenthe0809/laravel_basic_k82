<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Str;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    function getCategory()
    {
        $data['categories']=Category::all()->toArray();
        
        return view('backend.category.category',$data);
    }
    
    function getEditCategory($idCate)
    {
        $data['cate']=Category::findOrFail($idCate);
        $data['categories']=Category::all()->toArray();
        return view('backend.category.editcategory',$data);
    }

    function postEditCategory($idCate,request $r)
    {
        $cate=Category::findOrFail($idCate);
        $cate->name=$r->name;
        $cate->slug= Str::slug($r->name, '-');
        $cate->parent=$r->parent;
        $cate->save();
        return redirect()->back()->with('thongbao','Đã sửa thành công!');
    }

    function postCategory(AddCategoryRequest $r){
    //    phiên bản <=5.8;
        // str_slug($r->name);
    //  phiên bản >= 6.0
    $cate=new Category;
    $cate->name=$r->name;
    $cate->slug= Str::slug($r->name, '-');
    $cate->parent=$r->parent;
    $cate->save();
    return redirect()->back();
  
    }

    function delCategory($idCate)
    {
        // tìm danh mục chuẩn bị xoá
        $cate=Category::find($idCate);
        //lấy parent của danh mục chuẩn bị xoá
        $parent=$cate->parent;

        //Tìm danh mục con ngay sau danh mục chuẩn bị xoá
        //thay thế parent danh mục con = chính parent của danh mục chuẩn bị xoá
        Category::where('parent',$cate->id)->update(['parent'=>$parent]);

        //Xoá danh mục cần xoá
        Category::destroy($idCate);
        return redirect()->back();
    }
}
