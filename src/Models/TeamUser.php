<?php


namespace ZhyuVueCurd\Models;


use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    protected $table = 'team_user';
    protected $guarded = ['id'];
    public $timestamps = true;

}
