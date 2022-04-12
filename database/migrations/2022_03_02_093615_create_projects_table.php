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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('goal',4000);
            $table->string('material',4000);
            $table->unsignedBigInteger('assign_id');
            $table->integer('status')->default(0);
            $table->text('explain')->nullable();
            $table->timestamps();

            //forign Key
            $table->foreign('assign_id')->references('id')->on('assigns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
