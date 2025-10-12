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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->string('currency', 4)->default('FCFA');
            $table->string('location');
            $table->string('type'); // Villa, Appartement, Maison, etc.
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('surface_area', 8, 2)->nullable();
            $table->json('images')->nullable(); // Array des URLs d'images
            $table->string('status')->default('available'); // available, sold, reserved
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
