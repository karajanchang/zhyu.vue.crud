<?php


namespace ZhyuVueCurd\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZhyuVueCurd\Helper\ProccessUploadTrait;

/**
 * Class UploadController
 * @package ZhyuVueCurd\Http\Controllers
 */
class UploadController extends Controller
{
    use ProccessUploadTrait;

    /**
     * @param Request $request
     * @param string $dir
     * @param string $column
     * @param int|null $width
     * @param int|null $height
     * @param int|null $quality
     * @return string
     */
    public function store(Request $request, string $dir, string $column, int $width = null, int $height = null, int $quality = 70){
//        $file_name = $request->$column->getClientOriginalName();
//        Log::info('upload........', [$dir, $request->all('file')]);
//        Log::info('upload........ file_name', [$file_name, $request->file, $request->allFiles()]);
//        $path = Storage::putFile('public/'.$dir, $request->{$column});
//        $path = str_replace('public', '', $path);
//        Log::info('upload in .............'.$path);
        ray($dir, $request, $width, $height);
        $path = $this->proccessUpload($dir, $request->{$column}, $width, $height);

        return $path;
    }

    /**
     * @param Request $request
     * @param string $table
     * @param int|null $width
     * @param int|null $height
     * @param int|null $quality
     * @return mixed
     */
    public function ckeditor(Request $request, string $table, int $width = null, int $height = null, int $quality = 70){

//        $path = Storage::putFile('public/'.$table, $request->upload);
//        $path = str_replace('public', '', $path);
//        Log::info('upload in .............'.$path, [$request->all()]);

        $path = $this->proccessUpload($table, $request->upload, $width, $height);

        return response()->json([
            'uploaded' => true,
            'url' => '/storage/'.$path,
        ]);
    }

    /**
     * @param Request $request
     * @param string $dir
     * @param string $column
     * @param int|null $width
     * @param int|null $height
     * @param int|null $quality
     * @return string
     */
    public function froala(Request $request, string $dir, string $column, int $width = null, int $height = null, int $quality = 70){
        $path = $this->proccessUpload($dir, $request->{$column}, $width, $height);
        Log::info('response', [$dir, $column]);

        return [
            'link' => Storage::url($path),
        ];
    }

}
