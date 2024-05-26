<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('reference')->unique();
            $table->string('type');
            $table->string('title');
            $table->float('amount');
            // date de valeur
            $table->dateTime('value_date');
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('agency_id')->constrained('agency');
            $table->foreignId('created_by')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
