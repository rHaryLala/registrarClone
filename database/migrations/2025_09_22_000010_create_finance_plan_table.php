<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_plan', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('percentage')->nullable();
            $table->string('description')->nullable();
            $table->date('payment')->nullable();
            $table->dateTime('date_entry')->useCurrent();
            $table->string('type')->nullable();
            $table->string('last_change_user_id', 50)->nullable();
            $table->dateTime('last_change_datetime')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_plan');
    }
};
