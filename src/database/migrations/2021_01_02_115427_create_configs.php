<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
            $table->string('ctitle')->comment('顯示文字');
            $table->string('value')->nullable(true)->comment('內容');
            $table->unsignedTinyInteger('type')->comment('1.string  2.file 3.checkbox 4.select 5.radio 6.rich文字 7.url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
