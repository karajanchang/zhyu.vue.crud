<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('段落主旨');
            $table->longText('body')->nullable(true)->comment('文章內容');
            $table->string('pic')->nullable(true)->comment('圖片');
            $table->unsignedTinyInteger('pic_align')->nullable(true)->default(1)->comment('1置左 2置中 3置右');
            $table->unsignedInteger('orderby')->nullable(true)->default(1)->comment('排序');
            $table->boolean('is_online')->nullable(true)->default(true)->comment('是否有效');
            $table->unsignedBigInteger('page_id')->comment('關連 page id');
            $table->timestamps();

            $table->index(['orderby', 'is_online', 'page_id']);
        });

        Schema::table('page_contents', function (Blueprint $table) {
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_contents');
    }
}
