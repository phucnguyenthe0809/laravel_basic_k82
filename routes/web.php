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


Route::get('login','Backend\LoginController@getLogin'); 

// ---------------BACKEND
Route::group(['prefix' => 'admin'], function () {

    Route::get('','Backend\IndexController@getIndex'); 

    //category
    Route::group(['prefix' => 'category'], function () {
        Route::get('','Backend\CategoryController@getCategory');
        Route::post('','Backend\CategoryController@postCategory');


        Route::get('edit','Backend\CategoryController@getEditCategory');
    });

    //order
    Route::group(['prefix' => 'order'], function () {
        Route::get('','Backend\OrderController@getOrder');
        Route::get('detail','Backend\OrderController@getDetailOrder');
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
        Route::get('edit','Backend\UserController@getEditUser');
    });
    
});


