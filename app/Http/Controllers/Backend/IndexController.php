<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class IndexController extends Controller
{
    function getIndex()
    {
        $month=Carbon::now()->format('m');
        for ($i=1; $i <= $month ; $i++) { 
               $dl['Tháng '.$i]=0;
        }
       $data['dl']=$dl;
        return view('backend.index',$data);
    }
    function logout()
    {
        Auth::logout();
  
        return redirect('login');
  }
