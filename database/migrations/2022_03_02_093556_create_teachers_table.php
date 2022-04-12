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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('sicil')->unique();
            $table->unsignedBigInteger('role_id');
            $table->string('email')->unique();
            $table->string('name');
            $table->string('appellation')->nullable();
            $table->string('password');
            $table->timestamps();
            $table->string('picture')->default("default.png");

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
        Schema::dropIfExists('teachers');
    }
};
