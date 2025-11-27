<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->integer('is_default')->nullable()->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('sell')->default(0);
            $table->longText('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variations');
    }
}
