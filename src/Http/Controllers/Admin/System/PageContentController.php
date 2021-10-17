<?php


namespace ZhyuVueCurd\Http\Controllers\Admin\System;


use App\Http\Controllers\Controller;
use ZhyuVueCurd\Models\Page;
use ZhyuVueCurd\Models\PageContent;

class PageContentController extends Controller
{

    public function index(Page $page){

        $page_contents = $page->contents;

        return view('ZhyuVueCurd::admin.system.page-content.index', [
            'page' => $page,
            'title' => '頁面管理 - 版面設計 / '.$page->title,
        ]);
    }

    public function create(Page $page){

        return view('ZhyuVueCurd::admin.system.page-content.create', [
            'page' => $page,
            'title' => '頁面管理 - 版面設計 / '.$page->title,
        ]);
    }

    public function edit(Page $page, PageContent $pageContent){

        return view('ZhyuVueCurd::admin.system.page-content.edit', [
            'page' => $page,
            'pageContent' => $pageContent,
            'title' => '頁面管理 - 版面設計 / '.$page->title,
        ]);
    }
}
