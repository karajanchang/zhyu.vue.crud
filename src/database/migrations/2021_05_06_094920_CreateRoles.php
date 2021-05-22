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
            $table->boolean('is_online')->default(0)->nullable(true)->comment('是否有效');
            $table->unsignedSmallInteger('orderby')->default(1)->comment('排序');

            
            $table->index(['is_online']);
            $table->index(['is_online', 'orderby']);

            $table->timestamps();
        });


        $now = \Carbon\Carbon::now();
        DB::table('roles')->insert([
            [
                'name' => '超級管理員',
                'slug' => 'super_admin',
                'orderby' => 1,
                'is_online' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '管理員',
                'slug' => 'admin',
                'orderby' => 2,
                'is_online' => true,
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
