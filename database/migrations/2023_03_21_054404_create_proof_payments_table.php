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
        Schema::create('proof_payments', function (Blueprint $table) {
            $table->id();
            $table->string("order_code",100)
                ->references('code')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('payment_image',250)->nullable();
            $table->boolean("is_valid")->nullable();
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
        Schema::dropIfExists('proof_payments');
    }
};
