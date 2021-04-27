<?php


namespace ZhyuVueCurd\Http\Controllers;


use Illuminate\Support\Facades\Request;
use ZhyuVueCurd\Repositories\Admin\System\PageRepository;

class PageController extends Controller
{
    public function show(string $uri){
        $preview = (bool) Request::input('preview');
        $page = app(PageRepository::class)->findByUri($uri);

        return view()->first([
            'vendor.page.'.$uri,
            'ZhyuVueCurd::page.show',
        ],[
                'page' => $page,
                'preview' => $preview,
            ]
        );
    }

}
