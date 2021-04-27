<?php


namespace ZhyuVueCurd\Http\Controllers;


use ZhyuVueCurd\Repositories\Admin\System\PageRepository;

class PageController extends Controller
{
    public function show(string $uri){
        $page = app(PageRepository::class)->findByUri($uri);
        return view()->first([
                'vendor.page.'.$uri,
                'ZhyuVueCurd::page.show',
            ],[
                'page' => $page,
            ]
        );
    }

}
