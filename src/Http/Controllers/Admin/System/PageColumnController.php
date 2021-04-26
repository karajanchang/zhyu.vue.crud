<?php


namespace ZhyuVueCurd\Http\Controllers\Admin\System;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZhyuVueCurd\Models\PageColumn;
use ZhyuVueCurd\Models\PageContent;

class PageColumnController extends Controller
{

    public function edit(PageColumn $pageColumn, PageContent $pageContent){

        $page = $pageContent->page;

        return view('ZhyuVueCurd::admin.system.page-column.edit', [
            'pageColumn' => $pageColumn,
            'pageContent' => $pageContent,
            'title' => '頁面管理 - 版面設計 / '.$page->title,
        ]);
    }

    public function save(PageColumn $pageColumn, PageContent $pageContent, Request $request){
        $all = $request->all();

        $pageColumn->size = (int) $all['size'] ?? 6;
        $pageColumn->has_text_centered = isset($all['has_text_centered']) ? (int) $all['has_text_centered'] : 0;
        $pageColumn->alt = (string) $all['alt'] ?? null;
        $pageColumn->url = (string) $all['url'] ?? null;
        $pageColumn->ratio = (string) $all['ratio'] ?? null;
        $pageColumn->rounded = isset($all['rounded']) ? (int) $all['rounded'] : 0;
        $pageColumn->body = $all['body'] ?? null;
        $pageColumn->save();

        return redirect()->route('admin.system.pagecolumn.edit', ['page_content' => $pageContent, 'page_column' => $pageColumn]);

    }
}
