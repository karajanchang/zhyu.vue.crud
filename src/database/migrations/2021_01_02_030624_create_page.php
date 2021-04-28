<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('文章主旨');
            $table->string('banner')->nullable(true)->comment('banner');
            $table->string('uri')->nullable(true)->comment('符合url');
            $table->string('layout')->nullable(true)->comment('layout的名稱');
            $table->boolean('is_online')->default(false)->comment('是否有效');
            $table->unsignedBigInteger('menu_id')->nullable(true)->comment('關連 menu id');
            $table->unsignedSmallInteger('orderby')->default(1)->comment('排序');
            $table->timestamps();

            $table->index(['is_online', 'uri']);
            $table->index(['is_online', 'menu_id']);
            $table->index(['is_online', 'orderby']);
            $table->index(['orderby']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
