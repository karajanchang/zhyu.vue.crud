<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoles extends Migration
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

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable(false)->comment('權限角色slug');
            $table->string('name')->nullable(false)->comment('權限角色名稱');

            $table->timestamps();
        });


        $now = \Carbon\Carbon::now();
        DB::table('roles')->insert([
            [
                'name' => '超級管理員',
                'slug' => 'super_admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '管理員',
                'slug' => 'admin',
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
        Schema::drop('roles');
    }
}
