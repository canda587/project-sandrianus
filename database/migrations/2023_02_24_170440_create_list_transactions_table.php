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
        Schema::create('list_transactions', function (Blueprint $table) {
            $table->id("id_list_transaction");

            $table->string("transaction_code")
                ->references('code')
                ->on('transactions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // $table->unsignedBigInteger('item_id');
            $table->foreignId("item_id")
                ->references('id_item')
                ->on('items')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer("transaction_count");
            $table->integer("transaction_price");
            $table->integer("transaction_sub_total");
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
        Schema::dropIfExists('list_transactions');
    }
};
