<?php

namespace ZhyuVueCurd\Models;

use App\Models\Board;
use App\Models\BoardItemPic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardItem extends Model
{
    use HasFactory;
    protected $table = 'board_items';

    public $timestamps = true;

    protected $guarded = ['id'];

    public function board(){

        return $this->belongsTo(Board::class);
    }

    public function pics(){

        return $this->hasMany(BoardItemPic::class);
    }
}
