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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('advertisement_code');
            $table->string('name');
            $table->string('slug');
            $table->foreignId('province_id')->constrained()->onDelete('cascade');  
            $table->foreignId('advertisement_type_id')->constrained()->onDelete('cascade');  
            $table->foreignId('advertisement_catagory_id')->constrained()->onDelete('cascade');  
            $table->foreignId('type_of_time_id')->constrained()->onDelete('cascade');  
            $table->foreignId('gender_id')->constrained()->onDelete('cascade');  
            $table->foreignId('company_id')->constrained()->onDelete('cascade'); 
            
            $table->float('salary');
            $table->text('job_position');
            $table->text('important_skill');
            $table->text('duties');
            $table->boolean('status');
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
        Schema::dropIfExists('advertisements');
    }
};
