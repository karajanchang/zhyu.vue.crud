<?php

use Illuminate\Support\Facades\Route;

Route::group( [ 'middleware' => [], 'prefix' => '/admin', 'as' => 'admin.' ], function (){

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
