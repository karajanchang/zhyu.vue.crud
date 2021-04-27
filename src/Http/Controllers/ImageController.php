<?php


namespace ZhyuVueCurd\Http\Controllers;


use Illuminate\Http\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use ZhyuVueCurd\Models\PageColumn;

class ImageController extends Controller
{
    /**
     * 從base64字川取得圖片真實位址
     * @param $base64encode_iamge
     * @return string
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function getPath($image, $is_encode = false){
        if($is_encode===true) {
            $path = storage_path('app/public' . base64_decode($image));
        }else{
            $path = storage_path('app/public' . $image);
        }
        Log::info('getPath: '.$path);
        if(!file_exists($path)){
            abort(404);
        }

        return $path;
    }

    /**
     * 顯示圖片從base64 path
     * @param string $image
     * @return mixed
     */
    public function show(string $image){
        $path = $this->getPath($image, true);

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * 刪除圖片
     * @param string $image
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $image = null){
        if(is_null($image)){
            return response()->json(['success' => 'success'], 200);
        }
        $path = $this->getPath($image);
        try {
            unlink($path);

            return response()->json(['success' => 'success'], 200);
        }catch (\Exception $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroyByColumn(int $page_column){
        try {
            $pageColumn = PageColumn::find($page_column);
            Log::info('destroyByColumn:', [$pageColumn]);
            $pageColumn->pic = null;
            $pageColumn->save();

            $response = $this->destroy($pageColumn->pic);

            return $response;
        }catch (\Exception $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
