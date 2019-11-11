<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Cart;

class CartController extends Controller
{
    function getCart(){

        $data['cart']=Cart::content();
        $data['total']=Cart::total(0,"",".");
        return view('frontend.cart.cart',$data);
    }

    function addCart(request $r){
        $prd=Product::find($r->id_product);
        Cart::add(['id' => $prd->id,
        'name' => $prd->name,
        'qty' => $r->quantity,
        'price' => $prd->price,
        'weight' => 0,
        'options' => ['img' => $prd->img]]);
        return redirect('/cart');
    }

    function updateCart($rowId,$qty){

        Cart::update($rowId, $qty);
        return 'success';
    }
}
