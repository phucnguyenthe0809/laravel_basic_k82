<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Models\Order;
class IndexController extends Controller
{
    function getIndex()
    {
        $year=Carbon::now()->format('Y');
        $month=Carbon::now()->format('m');
        for ($i=1; $i <= $month ; $i++) {
               $dl['Tháng '.$i]=Order::where('state',1)
               ->whereMonth('updated_at',$i)
               ->whereYear('updated_at',$year)
               ->sum('total');
        }
        $data['order']=Order::where('state',1)
        ->whereMonth('updated_at',$month)
        ->whereYear('updated_at',$year);
        $data['month']=$month;

        // dd($dl);
       $data['dl']=$dl;
        return view('backend.index',$data);
    }
    function logout()
    {
        Auth::logout();

        return redirect('login');
  }
}
