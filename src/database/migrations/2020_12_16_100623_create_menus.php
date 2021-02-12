<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            DB::beginTransaction();

            Schema::create('menus', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable(false);
                $table->string('ctitle')->nullable(true);
                $table->string('url')->nullable(true);
                $table->string('icon_pack', 30)->nullable(true)->comment('icon-pack');
                $table->string('icon', 30)->nullable(true)->comment('icon名稱');
                $table->unsignedSmallInteger('orderby')->default(1);
                $table->unsignedSmallInteger('parent_id')->default(0);
                $table->boolean('is_can_delete')->default(1);
                $table->boolean('is_online')->default(1)->nullable(true)->comment('是否上線');

                $table->index(['orderby', 'parent_id']);
                $table->index(['orderby']);
                $table->index(['orderby', 'title']);

                $table->index(['title', 'is_online'], 'index_title_is_online');
                $table->index(['parent_id', 'is_online', 'orderby'], 'index_parent_id_is_online_orderby');
            });

            app(\ZhyuVueCurd\Repositories\Admin\System\MenuRepository::class)->initFirst();

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
