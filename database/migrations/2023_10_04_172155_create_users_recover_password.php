<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_recover_password', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->integer('user_id_fk')->unsigned()->unique();
            $table->foreign('user_id_fk')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('expires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_recover_password');
    }
};
