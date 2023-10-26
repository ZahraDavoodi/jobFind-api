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
        Schema::create('job_seekers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('gender_id')->constrained()->onDelete('cascade')->nullable();  
            $table->foreignId('province_id');  
            $table->text('address')->nullable();
            $table->float('salary')->nullable();
            $table->foreignId('type_of_time_id')->constrained()->onDelete('cascade')->nullable();  
            $table->foreignId('level_of_education_id')->constrained()->onDelete('cascade')->nullable();  
             $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable();  
            $table->text('courses_details')->nullable();
            $table->text('resume')->nullable();
            $table->text('personal_details')->nullable();
            $table->boolean('status');
            $table->boolean('ready_to_work');
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
        Schema::dropIfExists('job_seekers');
    }
};
