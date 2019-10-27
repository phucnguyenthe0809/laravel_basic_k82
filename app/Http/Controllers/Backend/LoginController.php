<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
   function getLogin()
   {
       return view('backend.login');
   }
   function postLogin(request $r)
   {
       $email=$r->email;
       $password=$r->password;
        if (Auth::attempt(['email' => $email, 'password' => $password],$r->has('remember'))) {
            return redirect('admin');
        }
        return redirect()->back()->with('thongbao','Tài khoản hoặc mật khẩu không chính xác!');
   }
}
