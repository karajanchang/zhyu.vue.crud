<?php

use Illuminate\Support\Facades\Route;

Route::group( [ 'middleware' => ['web'], 'prefix' => '/admin', 'as' => 'admin.' ], function (){

    //--logs
    #Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


    //--網站設定
    Route::group( [ 'middleware' => [ ], 'prefix' => '/system', 'as' => 'system.' ], function () {
        //--設定
        Route::resource('/config', \ZhyuVueCurd\Http\Controllers\Admin\System\ConfigController::class);
        Route::get('/config/{config}/namevalue', [\ZhyuVueCurd\Http\Controllers\Admin\System\ConfigController::class, 'namevalue'])->name('namevalue');
        Route::get('/config/{config}/setvalue', [\ZhyuVueCurd\Http\Controllers\Admin\System\ConfigController::class, 'setvalue'])->name('setvalue');
        //--選單管理
        Route::resource('/menu', \ZhyuVueCurd\Http\Controllers\Admin\System\MenuController::class);
        //--頁面管理
        Route::resource('/page', \ZhyuVueCurd\Http\Controllers\Admin\System\PageController::class);

        Route::get('/pagecontent/{page}/index', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageContentController::class, 'index'])->name('pagecontent.index');
        Route::get('/pagecontent/{page}/create', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageContentController::class, 'create'])->name('pagecontent.create');
        Route::get('/pagecontent/{page}/{page_content}/edit', [\ZhyuVueCurd\Http\Controllers\Admin\System\PageContentController::class, 'edit'])->name('pagecontent.edit');
    });
});

Route::group( [ 'middleware' => [ ], 'prefix' => '/vendor', 'as' => 'vendor.' ], function () {
    //--一定要有的
    Route::post('/upload/{dir}-{column}', '\\ZhyuVueCurd\\Http\\Controllers\\UploadController@store')->name('upload');
    Route::get('/ajax/select/{table}-{column}', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@select')->name('ajax.select');

    Route::group( [ 'middleware' => [ ], 'prefix' => '/ajax', 'as' => 'ajax.' ], function (){
        Route::group( [ 'middleware' => [ ], 'prefix' => '/{module}', 'as' => 'admin.' ], function (){
            Route::group( [ 'middleware' => [ ], 'prefix' => '/system', 'as' => 'system.' ], function (){
                Route::get('{tag}/menu', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('menu');
                Route::get('{tag}/page', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('page');
                Route::get('{tag}/pagecontent', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('pagecontent');
            });
        });
    });
//    Route::get('/vendor/ajax/admin/system/page', '\\ZhyuVueCurd\\Http\\Controllers\\AjaxController@index')->name('ajax.admin.system.page');
});