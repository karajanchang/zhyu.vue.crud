<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPageContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->string('title')->nullable(true)->comment('主標')->after('id')->change();
            $table->string('subtitle')->nullable(true)->comment('副標')->after('title');
            $table->unsignedTinyInteger('column_nums')->nullable(false)->default(2)->comment('欄位數量')->after('subtitle');
            $table->unsignedTinyInteger('gap')->nullable(true)->comment('間距 is-0 .. is-8')->after('column_nums');
            $table->boolean('is_vcentered')->nullable(true)->comment('縮小時變多行 is-vcentered')->after('gap');
            $table->boolean('is_multiline')->nullable(true)->comment('垂直對齊 is-multiline')->after('is_vcentered');
            $table->boolean('is_centered')->nullable(true)->comment('欄位置中 is-centered')->after('is_multiline');
            $table->boolean('container')->nullable(true)->comment('大螢幕維持固定寬度(1344px以下) container')->after('is_centered');
            $table->boolean('is_fluid')->nullable(true)->comment('永遠使用最大寬度(永遠左右保持32px) is-fluid')->after('container');

            $table->dropColumn(['body', 'pic', 'pic_align', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->longText('body')->nullable(true)->comment('文章內容')->after('title');
            $table->string('pic')->nullable(true)->comment('圖片')->after('body');
            $table->unsignedTinyInteger('pic_align')->default(1)->comment('1置左 2置中 3置右')->after('pic');
            $table->unsignedTinyInteger('type')->after('page_id')->default(1)->comment('1 表示圖文 2整頁')->after('pic_align');

            $table->dropColumn(['subtitle', 'column_nums', 'gap', 'is_vcentered', 'is_multiline', 'is_centered', 'container', 'is_fluid']);
        });
    }
}
