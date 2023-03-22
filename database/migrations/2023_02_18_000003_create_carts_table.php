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
        Schema::create('carts', function (Blueprint $table) {
            $table->id("id_cart");

            // $table->unsignedBigInteger('user_id');
            $table->foreignId("user_id")
                ->references('id_user')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // $table->unsignedBigInteger('item_id');
            $table->foreignId("item_id")
                ->references('id_item')
                ->on('items')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer("cart_count");
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
        Schema::dropIfExists('carts');
    }
};
