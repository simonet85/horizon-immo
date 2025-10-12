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
        Schema::table('properties', function (Blueprint $table) {
            // Modifier la longueur de la colonne currency pour supporter FCFA (4 caractères)
            $table->string('currency', 4)->default('FCFA')->change();
        });

        // Mettre à jour toutes les propriétés existantes avec FCFA
        DB::table('properties')->update(['currency' => 'FCFA']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Revenir à ZAR
            $table->string('currency', 3)->default('ZAR')->change();
        });

        DB::table('properties')->update(['currency' => 'ZAR']);
    }
};
