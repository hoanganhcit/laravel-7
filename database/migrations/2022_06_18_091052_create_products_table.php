<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku');
            $table->string('name');
            $table->string('slug');
            $table->integer('quantity')->default(0);
            $table->integer('sell')->default(0);
            $table->longText('short_description');
            $table->string('price');
            $table->string('discount')->nullable();
            $table->string('discount_price')->nullable();
            $table->string('date_discount_period', 50)->nullable();
            $table->integer('is_variation')->default(0);
            $table->integer('low_stock_to_notify')->nullable();
            $table->integer('status');
            $table->longText('description')->nullable();
            $table->text('photo')->nullable();
            $table->integer('featured_product')->nullable()->default(0);
            $table->integer('new_arrival')->nullable()->default(0);
            $table->integer('on_sale')->nullable()->default(0);
            $table->integer('viewed')->nullable()->default(0);
            $table->integer('sold')->nullable()->default(0);
            $table->string('meta_title', 100)->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('display_order')->default(1)->nullable();

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
