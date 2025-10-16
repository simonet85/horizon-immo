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
            // Ajout de la colonne town_id après category_id
            $table->foreignId('town_id')->nullable()->after('category_id')->constrained('towns')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Suppression de la contrainte de clé étrangère et de la colonne
            $table->dropForeign(['town_id']);
            $table->dropColumn('town_id');
        });
    }
};
