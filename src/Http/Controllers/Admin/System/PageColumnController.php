<?php


namespace ZhyuVueCurd\Http\Controllers\Admin\System;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ZhyuVueCurd\Helper\ProccessUploadTrait;
use ZhyuVueCurd\Models\PageColumn;
use ZhyuVueCurd\Repositories\Admin\System\PageColumnRepository;

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

        //$pageColumn->size = (int) $all['size'] ?? 6;
        try {
            $pageColumn->has_text_centered = isset($all['has_text_centered']) ? (int)$all['has_text_centered'] : 0;
            $pageColumn->width = isset($all['width']) ? $all['width'] : null;
            $pageColumn->height = isset($all['height']) ? $all['height'] : null;
            $pageColumn->alt = (string)$all['alt'] ?? null;
            $pageColumn->url = (string)$all['url'] ?? null;
            $pageColumn->ratio = (string)$all['ratio'] ?? null;
            $pageColumn->rounded = isset($all['rounded']) ? (int)$all['rounded'] : 0;
            $pageColumn->body = $all['body'] ?? null;

            //----開始上傳
            if (!is_null($request->pic)) {
                $pageColumn->pic = $this->proccessImageUpload($pageColumn, $request);
            }
            $pageColumn->save();

            return redirect()->route('admin.system.pagecolumn.edit', ['page_column' => $pageColumn])->with('status', 'success');
        }catch (\Exception $e){
            Log::error(__METHOD__, [$e]);
            return redirect()->route('admin.system.pagecolumn.edit', ['page_column' => $pageColumn])->with('status', 'fail');
        }

    }


    /**
     * 刪除欄位
     * @param PageColumn $pageColumn
     */
    public function destroy(PageColumn $pageColumn){
        Log::info('pageColumn destroy', [$pageColumn]);
        $this->destroyUpload($pageColumn->pic);

        $count = app(PageColumnRepository::class)->countByPageContentId($pageColumn->pageContent->id);
        $pageColumn->delete();

        //--如果只有一個也刪除了，把這個pageContent也刪除
        if($count==1){
            $pageColumn->pageContent->delete();
        }
    }
}
