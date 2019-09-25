<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function getIndex(){
       return view('frontend.index');
    }
    function getAbout(){
     return view('frontend.about');
    }
    function getContact(){
      return view('frontend.contact');
    }
}
