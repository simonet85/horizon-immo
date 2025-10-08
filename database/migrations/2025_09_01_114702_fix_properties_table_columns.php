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
            // Ajouter les nouvelles colonnes
            $table->string('city')->after('price');
            $table->text('address')->nullable()->after('city');
            $table->boolean('is_featured')->default(false)->after('status');
        });

        // Copier les données de location vers city après avoir créé la colonne
        \DB::statement('UPDATE properties SET city = location WHERE location IS NOT NULL');

        Schema::table('properties', function (Blueprint $table) {
            // Supprimer l'ancienne colonne location
            $table->dropColumn('location');

            // Renommer featured vers is_featured (si elle existe encore)
            if (Schema::hasColumn('properties', 'featured')) {
                \DB::statement('UPDATE properties SET is_featured = featured');
                $table->dropColumn('featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Restaurer l'ancienne structure
            $table->string('location')->after('price');
            $table->boolean('featured')->default(false)->after('status');

            // Copier les données
            \DB::statement('UPDATE properties SET location = city');
            \DB::statement('UPDATE properties SET featured = is_featured');

            // Supprimer les nouvelles colonnes
            $table->dropColumn(['city', 'address', 'is_featured']);
        });
    }
};
