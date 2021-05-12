<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitalDefaultTeams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!class_exists(\Laravel\Jetstream\Jetstream::class)){
            throw new Exception('Please install Jetstream with teams first!!!');
        }
        if(!Schema::hasTable('teams')){
            throw new Exception('Please install Jetstream with teams first!!!');
        }

        $count = DB::table('teams')->where('id', 1)->count();
        if($count > 0 ){
            throw new Exception('已有第一筆資料，請先清除teams的資料表!!!');
        }

        $now = \Carbon\Carbon::now();
        DB::table('teams')->insert([
            [
                'user_id' => 0,
                'name' => '超級管理員',
                'personal_team' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 0,
                'name' => '管理員',
                'personal_team' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 0,
                'name' => '訪客',
                'personal_team' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('teams')) {
            DB::table('teams')->truncate();
        }
    }
}
