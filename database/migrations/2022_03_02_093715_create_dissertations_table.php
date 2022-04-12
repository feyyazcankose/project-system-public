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
        Schema::create('dissertations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->boolean('status')->default(false);
            $table->string('explain')->nullable();
            $table->string('word_url');
            $table->string('pdf_url');
            $table->timestamps();
            //forign Key
            $table->foreign('report_id')->references('id')->on('reports');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dissertations');
    }
};
