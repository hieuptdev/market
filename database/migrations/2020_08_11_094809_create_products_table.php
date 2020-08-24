<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('seller_id');
            $table->unsignedBiginteger('customer_id')->nullable();
            $table->string('title');
            $table->unsignedBiginteger('category_id');
            $table->decimal('price', 10, 4);
            $table->text('desc');
            $table->text('image');
            $table->tinyInteger('status');
            $table->unsignedBiginteger('seller_address');
            $table->unsignedBiginteger('customer_address')->nullable();
            $table->timestamps();
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('seller_address')->references('id')->on('address')->onDelete('cascade');
            $table->foreign('customer_address')->references('id')->on('address')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
