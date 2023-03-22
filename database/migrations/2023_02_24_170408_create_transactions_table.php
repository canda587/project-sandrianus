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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id("id_transaction");
            $table->string("code",100)->unique();

            // $table->unsignedBigInteger('user_id');
            $table->foreignId("user_id")
                ->references('id_user')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId("status_id")
                ->references('id_status')
                ->on('status_orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->bigInteger("transaction_total");
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
        Schema::dropIfExists('transactions');
    }
};
