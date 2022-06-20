<?php

namespace ZhyuVueCurd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Config extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function typeWithName(){
        $value = null;
        Switch($this->type){
            case 2:
                $value = Storage::url($this->value);
                $type = '2 檔案';
                break;
            case 3:
                $type = '3 checkbox';
                break;
            case 4:
                $type = '4 select';
                break;
            case 5:
                $type = '5 radio';
                break;
            case 6:
                $type = '6 Rich文字';
                break;
            case 7:
                $type = '7 網址';
                break;
            default:
                $type = '1 文字';
        }
        $this->type_name = $type;
        if(!is_null($value)) {
            //$this->value = '<a href="'.$value.'"'.' target="_blank">按下預覽</a>';
        }
    }
}
