<?php


namespace ZhyuVueCurd\Http\Controllers\Admin;


use ZhyuVueCurd\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(){
        $redirect_route = env('ADMIN_LOGIN_REDIRECT_ROUTE', null);
        if(!is_null($redirect_route) && strlen($redirect_route) > 0) {

            return redirect()->route($redirect_route);
        }

        return view()->first([
            'vendor.admin.index',
            'vendor.admin.home',
            'vendor.admin.dashboard',
            'vendor.admin.welcome',
            'ZhyuVueCurd::admin.index',
        ]);
    }
}