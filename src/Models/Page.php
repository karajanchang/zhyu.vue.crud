<?php

namespace ZhyuVueCurd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';

    public function contents(){

        return $this->hasMany(PageContent::class);
    }

    public function left_menu(){

        return $this->belongsTo(Menu::class, 'left_menu_id');
    }
}
