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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->unsignedBigInteger('valid_memories_number')->default(value : 0);
            $table->unsignedBigInteger('invalid_memories_number')->default(value : 0);
            $table->unsignedBigInteger('ebooks_number')->default(value : 0);
            $table->unsignedBigInteger('physical_books_number')->default(value : 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
