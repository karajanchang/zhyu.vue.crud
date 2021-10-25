<?php

namespace ZhyuVueCurd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardItem extends Model
{
    use HasFactory;
    protected $table = 'board_items';

    public $timestamps = true;

    protected $guarded = ['id'];
}
