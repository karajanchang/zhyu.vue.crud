<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_columns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_content_id')->nullable(false)->comment('關連 id');
            $table->longText('body')->nullable(true)->comment('文章內容');
            $table->string('pic')->nullable(true)->comment('圖片');
            $table->string('alt')->nullable(true)->comment('備註');
            $table->string('ratio', 50)->nullable(true)->comment('長寬比率 3by4');
            $table->boolean('rounded')->default(false)->comment('是否圓邊');
            $table->string('url')->nullable(true)->comment('圖片上網址');

            $table->unsignedTinyInteger('size')->default(1)->nullable(true)->comment('欄位大小');
            $table->boolean('has_text_centered')->default(false)->comment('內容置中');
            $table->timestamps();
        });

        Schema::table('page_columns', function (Blueprint $table) {
            $table->foreign('page_content_id')->references('id')->on('page_contents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_columns');
    }
}
