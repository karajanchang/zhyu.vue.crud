<?php


namespace ZhyuVueCurd\Models;


use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    public $timestamps = false;

    public function children(){

        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

}
