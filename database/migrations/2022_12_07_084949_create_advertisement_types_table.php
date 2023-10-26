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
        Schema::create('advertisement_types', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string('slug')->nullable();      
            $table->string('seo_title')->nullable();            
            $table->text('key_words')->nullable();            
            $table->text('seo_description')->nullable();            
            $table->text('meta_data')->nullable();            
            $table->integer('reviews')->nullable();             
            $table->boolean("status");
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
        Schema::dropIfExists('advertisement_types');
    }
};
