<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('header')->nullable();
            $table->text('small_article')->nullable();
            $table->string('title')->nullable();
            $table->text('article')->nullable();            
            $table->text('image')->nullable();            
            $table->string('image_alt')->nullable();               
            $table->string('slug')->nullable();      
            $table->string('seo_title')->nullable();            
            $table->text('key_words')->nullable();            
            $table->text('seo_description')->nullable();            
            $table->text('meta_data')->nullable();            
            $table->integer('reviews')->nullable();             
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_us');
    }
};
