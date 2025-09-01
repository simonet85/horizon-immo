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
        Schema::create('accompaniment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('country_residence');
            $table->integer('age');
            $table->string('profession');
            $table->string('email');
            $table->string('phone');
            $table->string('desired_city');
            $table->string('property_type');
            $table->string('budget_range');
            $table->text('additional_info')->nullable();
            $table->integer('personal_contribution_percentage')->default(20);
            $table->string('status')->default('pending'); // pending, processing, completed, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accompaniment_requests');
    }
};
