<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_values', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名稱');
            $table->string('value')->comment('值');
            $table->unsignedBigInteger('config_id');
            $table->timestamps();

            $table->index(['config_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_values');
    }
}
