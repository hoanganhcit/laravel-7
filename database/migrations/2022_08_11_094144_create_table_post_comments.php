<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePostComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('post_id')->nullable();
            $table->text('name')->nullable();
            $table->text('email')->nullable();
            $table->text('message')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->integer('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
}
