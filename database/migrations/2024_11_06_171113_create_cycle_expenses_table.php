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
        Schema::create('cycle_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('cycle_id');
            $table->string('name_id');
            $table->string('name');
            $table->integer('amount');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cycle_expenses');
    }
};
