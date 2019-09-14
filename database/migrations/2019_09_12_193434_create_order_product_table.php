<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('order_id')
                ->references('id')
                ->on('order')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropForeign('order_product_order_id_foreign');
            $table->dropForeign('order_product_product_id_foreign');
        });

        Schema::dropIfExists('order_product');
    }
}
