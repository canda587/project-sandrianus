<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_orders', function (Blueprint $table) {
            // $table->engine = 'InnoDB';
            $table->id("id_list_order");

            // $table->string('order_code', 32)->references('code')->on('orders');
            $table->string("order_code",100)
                    ->references('code')
                    ->on('orders')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            // $table->unsignedBigInteger('item_id');
            $table->foreignId("item_id")
                ->references('id_item')
                ->on('items')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer("order_count");
            $table->integer("order_price");
            $table->integer("order_sub_total");
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
        Schema::dropIfExists('list_orders');
    }
};
