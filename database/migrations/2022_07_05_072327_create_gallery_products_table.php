<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryProductsTable extends Migration
{
    public function up()
    {
        Schema::create('gallery_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('galleries')->nullable();
            $table->integer('product_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gallery_products');
    }
}
