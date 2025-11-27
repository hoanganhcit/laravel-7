<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeValuesTable extends Migration
{
    public function up()
    {
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('product_attribute_id')->nullable();
            $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_attribute_values');
    }
}
