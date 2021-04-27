<?php


namespace ZhyuVueCurd\Http\Controllers\Admin\System;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ZhyuVueCurd\Helper\ProccessUploadTrait;
use ZhyuVueCurd\Models\PageColumn;
use ZhyuVueCurd\Models\PageContent;

class PageColumnController extends Controller
{
    use ProccessUploadTrait;

    public function edit(PageColumn $pageColumn){
        $page = $pageColumn->pageContent->page;

        return view('ZhyuVueCurd::admin.system.page-column.edit', [
            'pageColumn' => $pageColumn,
            'title' => '頁面管理 - 版面設計 / '.$page->title,
        ]);
    }

    /**
     * 上傳且取得圖片要存到db的path
     * @param PageColumn $pageColumn
     * @param Request $request
     * @return null
     * @throws \Intervention\Image\Exception\NotWritableException
     */
    private function proccessImageUpload(PageColumn $pageColumn, Request $request){
        $dir = 'page_columns/'.$pageColumn->id;
        $path = $this->proccessUpload($dir, $request->pic, 800, null, 70);

        /*
        $path = Storage::putFile('public/'.$dir, $request->pic);
        $real_path = storage_path('app/' . $path);
        Log::info('storage path: '.$path, [$real_path]);

        $image = Image::make($real_path)->resize(800, null, function($constraint){
            $constraint->aspectRatio();
        });
        $image->save($real_path, 70);
        */

        return $path;
    }


    public function save(PageColumn $pageColumn, Request $request){
        $all = $request->all();

        $pageColumn->size = (int) $all['size'] ?? 6;
        $pageColumn->has_text_centered = isset($all['has_text_centered']) ? (int) $all['has_text_centered'] : 0;
        $pageColumn->alt = (string) $all['alt'] ?? null;
        $pageColumn->url = (string) $all['url'] ?? null;
        $pageColumn->ratio = (string) $all['ratio'] ?? null;
        $pageColumn->rounded = isset($all['rounded']) ? (int) $all['rounded'] : 0;
        $pageColumn->body = $all['body'] ?? null;

        //----開始上傳
        if(!is_null($request->pic)) {
            $pageColumn->pic = $this->proccessImageUpload($pageColumn, $request);
        }
        $pageColumn->save();

        return redirect()->route('admin.system.pagecolumn.edit', ['page_column' => $pageColumn]);

    }


    /**
     * 刪除欄位
     * @param PageColumn $pageColumn
     */
    public function destroy(PageColumn $pageColumn){
        Log::info('pageColumn destroy', [$pageColumn]);
        $this->destroyUpload($pageColumn->pic);

        $pageColumn->delete();
    }
}
