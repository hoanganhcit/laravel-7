<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCmsAbout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_about', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('banner')->nullable();
            $table->text('introduction')->nullable();
            $table->text('brand_story')->nullable();
            $table->text('tech_photo')->nullable();
            $table->string('ingredient_photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cms_about');
    }
}
