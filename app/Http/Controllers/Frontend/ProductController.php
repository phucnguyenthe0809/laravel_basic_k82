<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product,Category};


class ProductController extends Controller
{
    function getDetail($slug_prd){
        $array=explode('-',$slug_prd);
        $id=array_pop($array);
        $data['product']=Product::find($id);
        $data['sp_new']=Product::where('img','<>','no-img.jpg')
        ->orderBy('updated_at','desc')->take(4)->get();
        return view('frontend.product.detail',$data);

    }
    function getShop(request $r){
        if ($r->start!='') {
            $data['products']=Product::whereBetween('price',[$r->start, $r->end])->paginate(3);

        } else {
            $data['products']=Product::paginate(3);
        }
        $data['categories']=Category::all();
        return view('frontend.product.shop',$data);
    }
    function getCatePrd(request $r,$id_cate){
        $data['categories']=Category::all();
        if ($r->start!='') {
            $data['products']=Product::where('category_id',$id_cate)
            ->whereBetween('price',[$r->start, $r->end])
            ->orderBy('id','desc')->paginate(3);
        } else {
            $data['products']=Product::where('category_id',$id_cate)
            ->orderBy('id','desc')->paginate(3);
        }
        return view('frontend.product.shop',$data);
    }
}
