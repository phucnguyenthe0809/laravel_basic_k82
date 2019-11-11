<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Requests\CheckoutRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use App\Models\Order;
class CheckoutController extends Controller
{
    function getCheckout(){
        $data['total']=Cart::total(0,"",".");
        $data['prd']=Cart::content();
        return view('frontend.checkout.checkout',$data);
    }

    function getComplete(){
        return view('frontend.checkout.complete');
    }

    function postCheckout(CheckoutRequest $r)
    {
        $total=Cart::total(0,"","");
        $order=new Order;
        $order->full=$r->full;
        $order->address=$r->address;
        $order->email=$r->email;
        $order->phone=$r->phone;
        $order->total=$total;
        $order->state=2;
        $order->save();
        return redirect('/checkout/complete');


    }
}
