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
        Schema::table('accompaniment_requests', function (Blueprint $table) {
            $table->decimal('monthly_income', 10, 2)->nullable()->after('personal_contribution_percentage');
            $table->decimal('existing_debt', 10, 2)->nullable()->after('monthly_income');
            $table->integer('loan_duration')->default(20)->after('existing_debt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accompaniment_requests', function (Blueprint $table) {
            $table->dropColumn(['monthly_income', 'existing_debt', 'loan_duration']);
        });
    }
};
