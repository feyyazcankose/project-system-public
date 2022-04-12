<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
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

        DB::table('admins')->insert([
            'email' => env('DEFAULT_EMAIL_ADDRESS', 'test@gmail.com'),
            'name' => env('DEFAULT_NAME','test'),
            'appellation'=>"Yönetici",
            'password' => Hash::make(env('DEFAULT_PASSWORD')),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'role_id'=>Role::where('title','admin')->first()->id
        ]);

    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
