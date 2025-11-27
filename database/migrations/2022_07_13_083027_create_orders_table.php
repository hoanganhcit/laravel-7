<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_code');
            $table->integer('total_product')->default(0);
            $table->decimal('total_price', 15, 2)->default(0);
            $table->decimal('total_tax', 15, 2)->default(0);
            $table->string('coupon_code')->nullable();
            $table->integer('delivery_status')->nullable();
            $table->integer('payment_status');
            $table->integer('payment_method')->nullable();
            $table->integer('shipping_id')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('fee_shipping')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
