<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
   
    //mặc định liên kết đến bảng users
    // protected $table="thanh_vien";(liên kết đến bảng xác định)

    //mặc định Khoá chính là id
    //protected $primaryKey = 'Tên khoá chính trong bảng'; 
    // protected $primaryKey = 'id_user';

    //mặc định timestamps:true; (có 2 trường created_at,update_at)
    // nếu không dùng 2 trường created_at,updated_at 
    public $timestamps=false;


    // mặc định khoá chính là khoá tự tăng (AI)
    // public $incrementing = false; (khoá chính không phải khoá tự tăng)
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function info()
    {
        return $this->hasOne('App\Models\info', 'id_users', 'id');
    }






}
