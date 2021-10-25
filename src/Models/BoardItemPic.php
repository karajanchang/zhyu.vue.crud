<?php

namespace ZhyuVueCurd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardItemPic extends Model
{
    use HasFactory;
    protected $table = 'board_item_pics';
    public $timestamps = true;

    protected $guarded = ['id'];
}
