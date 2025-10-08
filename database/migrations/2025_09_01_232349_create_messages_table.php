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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du contact
            $table->string('email'); // Email du contact
            $table->string('phone')->nullable(); // Téléphone (optionnel)
            $table->string('subject'); // Sujet du message
            $table->text('message'); // Message
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('set null'); // Propriété concernée (optionnel)
            $table->boolean('is_read')->default(false); // Statut de lecture
            $table->timestamp('read_at')->nullable(); // Date de lecture
            $table->text('admin_response')->nullable(); // Réponse de l'admin
            $table->timestamp('responded_at')->nullable(); // Date de réponse
            $table->timestamps();

            $table->index(['is_read', 'created_at']);
            $table->index('property_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
