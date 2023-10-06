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
        Schema::create('users_companies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('phone');
            $table->string('description');
            $table->integer('user_id_fk')->unsigned();
            $table->index('user_id_fk');
            $table->foreign('user_id_fk')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_companies', function (Blueprint $table){
            $table->dropForeign('users_companies_user_id_fk_foreign');
            $table->dropIndex('users_companies_user_id_fk_index');
            $table->dropColumn('user_id_fk');
        });

        Schema::dropIfExists('users_companies');
    }
};
