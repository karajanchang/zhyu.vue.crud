<?php

namespace ZhyuVueCurd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    protected $table = 'page_contents';

    public function page(){

        return $this->belongsTo(Page::class);
    }

    public function columns(){

        return $this->hasMany(PageColumn::class);
    }
}
