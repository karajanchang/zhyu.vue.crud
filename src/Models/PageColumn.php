<?php

namespace ZhyuVueCurd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageColumn extends Model
{
    use HasFactory;

    protected $table = 'page_columns';

    public function pageContent(){

        return $this->belongsTo(PageContent::class);
    }
}
