<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrderCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('city_id', 5)->nullable();
            $table->string('province_id', 5)->nullable();
            $table->string('ward_id', 5)->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_customers');
    }
}
