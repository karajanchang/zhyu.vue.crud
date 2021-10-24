<?php

use Illuminate\Support\Facades\Route;

//---這裡不能在middleware放入auth，不然會拿不到auth csrf_token
Route::group( [ 'middleware' => ['web'], 'prefix' => '/admin', 'as' => 'admin.' ], function (){
    //--後台首頁
    Route::get('/', [ \ZhyuVueCurd\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');

    //--權限設定
    Route::group( [ 'middleware' => [], 'prefix' => '/permission', 'as' => 'permission.' ], function () {
        //--資源管理
        Route::resource('/resource', \ZhyuVueCurd\Http\Controllers\Admin\Permission\ResourceController::class);

        //--角色管理
        Route::resource('/role', \ZhyuVueCurd\Http\Controllers\Admin\Permission\RoleController::class);

        //--角色管理 - 設定權限
        Route::get('/role/{role}/permission-set', [\ZhyuVueCurd\Http\Controllers\Admin\Permission\RoleController::class, 'permissionSet'])->name('role.permission.set');
        Route::patch('/role/{role}/permission-save', [\ZhyuVueCurd\Http\Controllers\Admin\Permission\RoleController::class, 'permissionSave'])->name('role.permission.save');

        //--使用者管理
        Route::resource('/user', \ZhyuVueCurd\Http\Controllers\Admin\Permission\UserController::class);
        Route::get('/user/{user}/role-set', [\ZhyuVueCurd\Http\Controllers\Admin\Permission\UserController::class, 'roleSet'])->name('user.role.set');
        Route::patch('/user/{user}/role-save', [\ZhyuVueCurd\Http\Controllers\Admin\Permission\UserController::class, 'roleSave'])->name('user.role.save');
    });

    Route::group( [ 'middleware' => [], 'prefix' => '/announcement', 'as' => 'announcement.' ], function () {
        Route::get('/board/{board}/arrangement', [\ZhyuVueCurd\Http\Controllers\Admin\Announcement\BoardController::class, 'arrangement'])->name('board.arrangement');
    });
    //--網站設定
    Route::group( [ 'middleware' => [], 'prefix' => '/system', 'as' => 'system.' ], function () {
        //--設定
        Route::resource('/config', \ZhyuVueCurd\Http\Controllers\Admin\System\ConfigController::class);
        Route::get('/config/{config}/namevalue', [\ZhyuVueCurd\Http\Controllers\Admin\System\ConfigController::class, 'namevalue'])->name('namevalue');
        Route::get('/config/{config}/setvalue', [\ZhyuVueCurd\Http\Controllers\Admin\System\ConfigController::class, 'setvalue'])->name('setvalue');

        //--選單管理
        Route::resource('/menu', \ZhyuVueCurd\Http\Controllers\Admin\System\MenuController::class);

        //--頁面管理
        Route::resource('/page', \ZhyuVueCurd\Http\Controllers\Admin\System\PageController::class);
        Route::get('/page/{page}/arrangement', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageController::class, 'arrangement'])->name('page.arrangement');


        Route::get('/pagecontent/{page}/index', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageContentController::class, 'index'])->name('pagecontent.index');
        Route::get('/pagecontent/{page}/create', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageContentController::class, 'create'])->name('pagecontent.create');
        Route::get('/pagecontent/{page}/{page_content}/edit', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageContentController::class, 'edit'])->name('pagecontent.edit');

        Route::get('/pagecolumn/{page_column}/edit', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageColumnController::class, 'edit'])->name('pagecolumn.edit');
        Route::post('/pagecolumn/{page_column}/save', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageColumnController::class, 'save'])->name('pagecolumn.save');
        Route::delete('/pagecolumn/{page_column}/destroy', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageColumnController::class, 'destroy'])->name('pagecolumn.destroy');
    });



});

Route::group( [ 'middleware' => [ ], 'prefix' => '/image', 'as' => 'image.' ], function () {
    Route::get('/{image}', '\\ZhyuVueCurd\\Http\\Controllers\\ImageController@show')->name('show');
    Route::delete('/{image}/destroy', '\\ZhyuVueCurd\\Http\\Controllers\\ImageController@destroy')->name('destroy');
    Route::delete('/{page_column}/destroy-column', '\\ZhyuVueCurd\\Http\\Controllers\\ImageController@destroyByColumn')->name('destroy.column');
});

Route::group( [ 'middleware' => [], 'prefix' => '/vendor', 'as' => 'vendor.' ], function () {
    //--一定要有的
    Route::post('/upload/{dir}-{column}/{width?}/{height?}/{quailty?}', '\\ZhyuVueCurd\\Http\\Controllers\\UploadController@store')->name('upload');
    Route::get('/ajax/select/{table}-{column}/{from}-{field}/{module?}/{tag?}', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@select')->name('ajax.select');

    Route::post('/froala/{dir}-{column}/{width?}/{height?}/{quailty?}', '\\ZhyuVueCurd\\Http\\Controllers\\UploadController@froala')->name('froala');
    Route::post('/ckeditor/{table}/{width?}/{height?}/{quailty?}', '\\ZhyuVueCurd\\Http\\Controllers\\UploadController@ckeditor')->name('ckeditor');

    Route::group( [ 'middleware' => [ ], 'prefix' => '/ajax', 'as' => 'ajax.' ], function (){
        Route::group( [ 'middleware' => [ ], 'prefix' => '/{module}', 'as' => 'admin.' ], function (){

            //--權限設定
            Route::group( [ 'middleware' => [], 'prefix' => '/permission', 'as' => 'permission.' ], function () {
                Route::get('{tag}/resource', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('resource');
                Route::get('{tag}/role', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('role');
                Route::get('{tag}/user', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('user');
            });

            //--網站設定
            Route::group( [ 'middleware' => [ ], 'prefix' => '/system', 'as' => 'system.' ], function (){
                Route::get('{tag}/menu', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('menu');
                Route::get('{tag}/page', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('page');
                Route::get('{tag}/pagecontent', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('pagecontent');
            });
        });
    });
//    Route::get('/vendor/ajax/admin/system/page', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('ajax.admin.system.page');
});

//---頁面管理產生的uri
Route::group( [ 'middleware' => [], 'prefix' => '/page', 'as' => 'page.' ], function () {
    if(\Illuminate\Support\Facades\Schema::hasTable('pages')) {
        foreach (\Illuminate\Support\Facades\DB::table('pages')->cursor() as $page) {
            Route::get('/{uri}', '\\ZhyuVueCurd\\Http\\Controllers\\PageController@show')->name($page->uri);
        }
    }
});

