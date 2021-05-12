<?php


namespace ZhyuVueCurd\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceRolePermission extends Model
{
    use HasFactory;

    protected $table = 'resource_role_permissions';
    public $timestamps = true;

    protected $guarded = ['id'];

    public function resource(){

        return $this->belongsTo(Resource::class);
    }

    public function role(){

        return $this->belongsTo(Role::class);
    }
}
