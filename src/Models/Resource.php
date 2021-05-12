<?php


namespace ZhyuVueCurd\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';
    public $timestamps = true;

    protected $guarded = ['id'];

    public function permissions(){

        return $this->hasMany(ResourceRolePermission::class);
    }
}
