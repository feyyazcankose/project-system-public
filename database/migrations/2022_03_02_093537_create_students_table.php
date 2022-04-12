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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->string('tc', 11)->unique();
            $table->string('student_number')->unique();
            $table->string('email')->unique();
            $table->string('name');
            $table->datetime('birth');
            $table->string('departman');
            $table->string('faculty');
            $table->string('university');
            $table->string('picture')->default("default.png");
            $table->string('phone_number');
            $table->string('password');
            $table->timestamps();

            //Foreign Key
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
