<?php


namespace ZhyuVueCurd\Http\Traits;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

//TODO: 加上判斷是不是圖片

/**
 * 給Livewire上傳用的
 * Trait LwGetUploadTrait
 * @package ZhyuVueCurd\Http\Traits
 */

trait LwGetUploadTrait
{
    /**
     * @param $dir
     * @param $name
     * @param array|int[] $hw
     * @return string[]
     */
    private function getFileUpload($dir, $name): array
    {
        $file = $this->{$name};
        if (is_null($file)) {

            return [];
        }
        $file_name = Str::uuid() . '.' . $file->extension();
        $destination = storage_path('app/public/' . $dir);
        $url = '/' . $dir . '/' . $file_name;
        Storage::put('public/' . $dir . '/' . $file_name, $this->{$name}->get());


        return [
            'path' => $destination . '/' . $file_name,
            'url' => $url,
        ];
    }

    /**
     * @param $dir
     * @param $name
     * @param array|int[] $hw
     * @return string[]
     */
    private function getUpload($dir, $name, array $hw = [300, 300]): array
    {
        $image = $this->{$name};
        if (is_null($image)) {

            return [];
        }
        $image_name = Str::uuid() . '.' . $image->extension();
        $destination = storage_path('app/public/' . $dir);
        $url = '/' . $dir . '/' . $image_name;

        $img = Image::make($image->path());
        $width = $img->width();
        $height = $img->height();
        $ratio = $width / $height;
        $ratio2 = $hw[0] / $hw[1];


        $canvas = Image::canvas($hw[0], $hw[1], '#cccccc');
        if ($ratio <= $ratio2) {
            $img->resize(null, $hw[1], function ($constraint) {
                $constraint->aspectRatio();
            });


        } else {
            $img->resize($hw[0], null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $canvas->insert($img, 'center');
        $canvas->save($destination . '/' . $image_name);

        /*
        $img->fit($hw[0], $hw[1], function ($constraint) {
            //$constraint->aspectRatio();
            $constraint->upsize();
        })->save($destination.'/'.$image_name);
        */

        return [
            'path' => $destination . '/' . $image_name,
            'url' => $url,
        ];
    }

    /**
     * 若是修改的話把上傳的規則拿掉
     * @param string $pic_col
     * @param int|null $id
     * @param array $upload
     * @return array|string[]
     */
    private function parseRules(string $pic_col, int $id = null, array $upload = [])
    {
        if (!isset($id)) {
            ray('新增：規則', $this->rules);

            return $this->rules;
        }

        //---若是修改，但沒有上傳圖片的話把圖片相關的rules移除
        if (count($upload) == 0) {
            $new_rules = [];

            $rules = isset($this->mod_rules) ? $this->mod_rules : $this->rules;
            foreach ($rules as $key => $rule) {
                $keys = explode('.', $key);
                if ($pic_col != $keys[0]) {
                    $new_rules[$key] = $rule;
                }
            }
            ray('修改：新規則', $rules, $new_rules);
            return $new_rules;
        }

        return $this->mod_rules;
    }
}
