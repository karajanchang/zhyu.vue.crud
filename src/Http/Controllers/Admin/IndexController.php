<?php


namespace ZhyuVueCurd\Http\Controllers\Admin;


use Illuminate\Support\Facades\Auth;
use ZhyuVueCurd\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(){
        if(!Auth::check()){
            return redirect()->to('/admin/login');
        }
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