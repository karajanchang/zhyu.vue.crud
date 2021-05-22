<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->comment('資源slug');
            $table->string('name')->comment('資源名稱');
            $table->boolean('is_online')->default(0)->nullable(true)->comment('是否有效');
            $table->unsignedSmallInteger('orderby')->default(1)->comment('排序');
            $table->timestamps();

            $table->index(['is_online']);
            $table->index(['is_online', 'orderby']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
