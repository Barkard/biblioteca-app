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
        Schema::table('loan_returns', function (Blueprint $table) {
            $table->date('loan_date')->nullable()->after('user_id');
            $table->string('status')->default('activo')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_returns', function (Blueprint $table) {
            $table->dropColumn('loan_date');
            $table->boolean('status')->default(true)->change();
        });
    }
};
