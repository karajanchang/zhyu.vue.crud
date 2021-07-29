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

        $this->imageProcess($real_path, $width, $height, $quality);

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

    /**
     * @param string $mime_type
     * @param string $real_path
     * @param int|null $width
     * @param int|null $height
     * @param int $quality
     */
    private function imageProcess(string $real_path, ?int $width, ?int $height, int $quality): void
    {
        $mime_type = mime_content_type($real_path);
        ray('mime_type: '.$mime_type);

        if (strstr($mime_type, 'image')) {
            $imageSize = getimagesize($real_path);
            if (is_null($width) && is_null($height)) {
                $width = env('DEFAULT_IMAGE_RESIZE_WIDTH', 1024);
            }

            //---上傳的圖片比較小，不要去放大
            if (!is_null($width) && ($width > $imageSize[0])) {
                $width = $imageSize[0];
            }

            //---上傳的圖片比較小，不要去放大
            if (!is_null($height) && ($height > $imageSize[1])) {
                $height = $imageSize[1];
            }

            $image = Image::make($real_path)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save($real_path, $quality);
        }
    }
}
