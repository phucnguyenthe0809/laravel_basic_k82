<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// --LÝ THUYẾT
//tạo cấu trúc cơ sở dữ liệu

Route::group(['prefix' => 'schema'], function () {
    // tạo bảng
    Route::get('create-order-and-product-order', function () {
        

        //tạo bảng order schema
        Schema::create('order', function ($table) {

            
            $table->bigIncrements('id');
            $table->string('full'); 
            $table->string('address')->nullable();  //cho phép để trống cột address
            $table->string('email'); 
            $table->string('phone'); 
            $table->decimal('total',18);

            $table->tinyInteger('state')->unsigned(); // state Kiểu tinyInt  Dạng không dấu


            $table->timestamps(); // Tạo 2 cột created_at, update_at
        });

        //Tạo bảng product_order
        Schema::create('product_order', function ($table) {
            $table->bigIncrements('id');
            $table->string('code', 45);
            $table->string('name');
            $table->decimal('price',18);
            $table->tinyInteger('qty');
            $table->string('img'); 

            //tạo khoá ngoại
            $table->bigInteger('order_id')->unsigned();
        });

    });

    //xoá bảng
    Route::get('del-table', function () {
        //Schema::drop('sdfsd'); // nếu không có bảng sẽ Lỗi;

        Schema::dropIfExists('order'); //Nếu không có bảng vẫn chạy bình thường.
        Schema::dropIfExists('product_order');
    });

    //sửa bảng
    Route::get('rename-table', function () {
        Schema::rename('order', 'orders');
    });

    // tác động vào cột trong bảng

    Route::get('del-col', function () {
        
        Schema::table('orders', function ( $table) {
            $table->dropColumn('updated_at');
        });

    });


    //thay đổi thuộc tính của cột
    Route::get('change-col', function () {

        Schema::table('orders', function ($table) {
            // thay đổi thuộc tính của cột
                $table->string('email', 50)->change();
                $table->integer('total')->change();

            //bổ xung cột mới
                $table->string('zzzzz');
        });

    });



    
});

//query buider
Route::group(['prefix' => 'query'], function () {
    //Thêm bản ghi vào trong bảng
    Route::get('insert', function () {
        //tên cột trong bảng users :email,full,password,address,phone,level
        DB::table('users')->insert([
                                    'email'=>'phuc@gmail.com',
                                    'full'=>'Thế phúc',
                                    'password'=>'123456',
                                    'address'=>'thường tín',
                                    'phone'=>'0213213445',
                                    'level'=>1
                                    ]);
                                   
        //tạo nhiều bản ghi cùng lúc
        DB::table('users')->insert([
        ['email'=>'A@gmail.com','full'=>'Thế A','password'=>'123456','address'=>'thường A','phone'=>'02113445','level'=>1],
        ['email'=>'B@gmail.com','full'=>'Thế B','password'=>'123456','address'=>'thường B','phone'=>'0213213445','level'=>1],
        ['email'=>'C@gmail.com','full'=>'Thế C','password'=>'123456','address'=>'thường C','phone'=>'0213213445','level'=>1]
        ]
        );
        });
     
    //sửa dữ liệu trong bảng
    Route::get('update', function () {
        // where: lọc ra những bản ghi cần sửa
        DB::table('users')->where('id',1)->update([
                                                    'email'=>'D@gmail.com',
                                                    'full'=>'Thế D',
                                                    'password'=>'123456',
                                                    'address'=>'thường D',
                                                    'phone'=>'0213213445',
                                                    'level'=>1
                                                    ]);
        
        
    });

    //xoá bảng
    Route::get('del', function () {
        //xoá bản ghi theo điều kiện
            DB::table('users')->where('id',1)->delete();
        //xoá tất cả bản ghi trong bảng
        //DB::table('users')->delete();
    });

    //nâng cao
    //lấy dữ liệu kết thúc bằng: get(),first()
    //chú ý Phương thức get() dùng để lấy danh sách nhiều bản ghi, 
    //first() lấy ra bản ghi đầu tiên

    Route::get('get-all-data', function () {
        //lấy toàn bộ dữ liệu
        $users=DB::table('users')->get();
        dd($users);
    });
    Route::get('get-first-data', function () {
        //lấy bản ghi đầu tiên
        $user=DB::table('users')->first();
        dd($user);
    });


    //chọn trường hiển thị
    Route::get('select', function () {
        $user=DB::table('users')->select('id','full')->get();
        dd($user);
    });

    //lấy dữ liệu theo điều kiện
    Route::get('where', function () {
        //where lồng nhau sẽ lich động hơn khi lấy dữ liệu
        // $users=DB::table('users')->where('id','>',13)->where('id','<',16)->get();


        // whereBetween('tên trường',[x,y]) lấy bản ghi có tên trường trong khoảng x đến y
        $users=DB::table('users')->whereBetween('id',[14,16])->get();
        dd($users);
    });



    Route::get('or-where', function () {
        
        $users=DB::table('users')->where('id','<',14)->orwhere('id','>',15)->get();
        dd($users);
    });

    //sắp xếp
    Route::get('orderby', function () {
        $users=DB::table('users')->where('id','<',14)->orwhere('id','>',15)->orderBy('id','DESC')->get();
        dd($users);
    });


    //giới hạn kết quả tìm kiếm

    Route::get('limit', function () {
        //skip đứng từ vị trí thứ 2  lấy 3  bản ghi
        //nếu không có skip -> đứng từ 0
        $users=DB::table('users')->skip(2)->take(3)->get();
        dd($users);
    });

    //lấy giá trị trung bình
    Route::get('avg', function () {
        $tb=DB::table('users')->where('id','>',13)->avg('id');
        dd($tb);
    });

     //lấy giá trị sum
     Route::get('sum', function () {
        $tb=DB::table('users')->where('id','>',13)->sum('id');
        dd($tb);
    });

    //increment
    Route::get('increment', function () {
        DB::table('users')->where('id','>',13)->increment('level',1);

    });


    //decrement
    Route::get('decrement', function () {
        DB::table('users')->where('id','>',13)->decrement('level',1);

    });



});


Route::group(['prefix' => 'lien-ket'], function () {

    //chú ý:
    //bảng chính : là bảng chứa khoá chính
    //bảng phụ : là bảng chứ khoá ngoại


    //liên kết 1-1 theo chiều thuận (liên kết từ bảng chính tới bảng phụ)
    Route::get('lk1-1-t', function () {
        $data['user']=App\User::find(13);
        return view('lien-ket',$data);
    });

    //liên kết 1-1 theo chiều nghịch (liên kết từ bảng phụ tới bảng chính)
    Route::get('lk1-1-n', function () {
        $data['info']=App\Models\info::find(2);
        return view('lien-ket',$data);
    });

    //liên kết 1-n 
    Route::get('lk1-n', function () {
        $data['cate']=App\Models\Category::find(6);
        return view('lien-ket',$data);
    });



    //liên kết n-n


});

//model
Route::get('test-model', function () {
    dd(App\User::find(13)->toarray());
});

// ---------------FRONTEND
Route::get('','Frontend\HomeController@getIndex');
Route::get('about','Frontend\HomeController@getAbout');
Route::get('contact','Frontend\HomeController@getContact');

//cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('','Frontend\CartController@getCart');
});

//checkout
Route::group(['prefix' => 'checkout'], function () {
    Route::get('','Frontend\CheckoutController@getCheckout');
    Route::post('','Frontend\CheckoutController@postCheckout');
    Route::get('complete','Frontend\CheckoutController@getComplete');
});

//product
Route::group(['prefix' => 'product'], function () {
    Route::get('shop','Frontend\ProductController@getShop');
    Route::get('detail','Frontend\ProductController@getDetail');
});


Route::get('login','Backend\LoginController@getLogin')->middleware('checkLogout'); 
Route::post('login','Backend\LoginController@postLogin'); 

// ---------------BACKEND
Route::group(['prefix' => 'admin','middleware'=>'checkLogin'], function () {
    Route::get('','Backend\IndexController@getIndex'); 
    Route::get('logout','Backend\IndexController@logout'); 
    //category
    Route::group(['prefix' => 'category'], function () {
        Route::get('','Backend\CategoryController@getCategory');
        Route::post('','Backend\CategoryController@postCategory');
        Route::get('edit/{idCate}','Backend\CategoryController@getEditCategory');
        Route::post('edit/{idCate}','Backend\CategoryController@postEditCategory');
        Route::get('delete/{idCate}','Backend\CategoryController@delCategory');
    });

    //order
    Route::group(['prefix' => 'order'], function () {
        Route::get('','Backend\OrderController@getOrder');
        Route::get('detail/{idOrder}','Backend\OrderController@getDetailOrder');
        Route::get('xu-ly/{idOrder}','Backend\OrderController@xuLy');
        Route::get('processed','Backend\OrderController@getProcessed');
    });

    //product
    Route::group(['prefix' => 'product'], function () {
        Route::get('','Backend\ProductController@getListProduct');

        Route::get('add','Backend\ProductController@getAddProduct');
        Route::post('add','Backend\ProductController@postAddProduct');

        Route::get('edit','Backend\ProductController@getEditProduct');
    });

    //user
    Route::group(['prefix' => 'user'], function () {
        Route::get('','Backend\UserController@getListUser');
        Route::get('add','Backend\UserController@getAddUser');
        Route::post('add','Backend\UserController@postAddUser');
        Route::get('edit/{idUser}','Backend\UserController@getEditUser');
        Route::post('edit/{idUser}','Backend\UserController@postEditUser');
        Route::get('del/{idUser}','Backend\UserController@delUser');
    });
    
});
