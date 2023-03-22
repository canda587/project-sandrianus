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
        Schema::create('items', function (Blueprint $table) {
            $table->id("id_item");
            
            // $table->unsignedBigInteger('category_id');
            $table->foreignId('category_id')
                ->references('id_category')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('item_name',100);
            $table->text('item_description');
            $table->integer('item_weight');
            $table->integer('item_price');
            $table->integer('item_stock');
            $table->string('item_image',250);
            $table->string('slug',150)->unique();
            $table->timestamps();

           
            // $table->foreign('category_code')->references('code')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
