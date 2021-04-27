<?php


namespace ZhyuVueCurd\Helper;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * 處理圖片上傳
 * Trait ProccessUploadTrait
 * @package ZhyuVueCurd\Helper
 */
trait ProccessUploadTrait
{
    public function proccessUpload($dir, UploadedFile $requestUploadObj = null, int $width = null, int $height = null, int $quality = 70){
        if(is_null($requestUploadObj)){

            return null;
        }

        $path = Storage::putFile('public/'.$dir, $requestUploadObj);
        $real_path = storage_path('app/' . $path);
        Log::info('ProccessUploadTrait storage path: '.$path, [$real_path]);

        $image = Image::make($real_path)->resize($width, $height, function($constraint){
            $constraint->aspectRatio();
        });
        $image->save($real_path, $quality);

        return str_replace('public', '', $path);
    }

    public function destroyUpload($filename){
        $file = $this->realpathFromDb($filename);
        @unlink($file);
    }

    public function realpathFromDb($filename){
        $file = $real_path = storage_path('app/public' . $filename);

        return $file;
    }
}
