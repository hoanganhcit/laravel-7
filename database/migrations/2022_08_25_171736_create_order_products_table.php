<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->decimal('price', 15, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->decimal('weight')->default(0);
            $table->longText('meta')->nullable(); // {"2":[{"id":"4","name":"Pound","product_attribute_name":"C\u00e2n N\u1eb7ng"}]}
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}

