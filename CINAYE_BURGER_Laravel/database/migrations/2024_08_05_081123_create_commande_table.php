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
        Schema::create('commande', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Utilisateur');
            $table->foreign('Utilisateur')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            Schema::enableForeignKeyConstraints();
            $table->unsignedBigInteger('Burger');
            $table->foreign('Burger')->references('id')->on('burgers')->onUpdate('cascade')->onDelete('cascade');
            Schema::enableForeignKeyConstraints();
            $table->integer("Etat")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande');
        Schema::table('commande', function (Blueprint $table) {
            //
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['Utilisateur']);
        });
        Schema::table('commande', function (Blueprint $table) {
            //
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['Burger']);
        });
    }
};
