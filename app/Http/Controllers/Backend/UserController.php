<?php

namespace App\Http\Controllers\Backend;
use  App\Http\Requests\AddUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    function getListUser()
    {
        $data['users']=User::paginate(3);
        return view('backend.user.listuser',$data);
    }

    function getAddUser()
    {
        return view('backend.user.adduser');
    }

    function getEditUser($idUser)
    {
        $data['user']=User::findOrFail($idUser);
        return view('backend.user.edituser',$data);
    }
    function postAddUser(AddUserRequest $r)
    {
        
        $user=new User;
        $user->email=$r->email;
        $user->full=$r->full;
        $user->password=bcrypt($r->password);
        $user->address=$r->address;
        $user->phone=$r->phone;
        $user->level=$r->level;
        $user->save();
        return redirect('admin/user')->with('thongbao','Đã Thêm Thành công!');
    }
    function postEditUser($idUser,request $r)
    {
        $user=User::find($idUser);
        $user->email=$r->email;
        $user->full=$r->full;

        if($r->password!='')
        {
            $user->password=bcrypt($r->password);
        }

        $user->address=$r->address;
        $user->phone=$r->phone;
        $user->level=$r->level;
        $user->save();
        return redirect()->back();
    }

    function delUser($idUser)
    {
        User::destroy($idUser);
        return redirect()->back();
    }
}
