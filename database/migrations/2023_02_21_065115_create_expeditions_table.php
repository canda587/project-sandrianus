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
        Schema::create('expeditions', function (Blueprint $table) {
            $table->id("id_expedition");

            $table->string("order_code",100)
                ->references('code')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->string("expedition_type",50);
            $table->string("expedition_service",100);
            $table->string("estimation",50);
            $table->integer("weight");
            $table->integer("cost");
            $table->text("origin");
            $table->text("destination");
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
        Schema::dropIfExists('expeditions');
    }
};
