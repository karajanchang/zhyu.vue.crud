<?php


namespace ZhyuVueCurd\Models;


use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = 'boards';
    public $timestamps = true;

    protected $guarded = ['id'];

    public function items(){


    }
}
