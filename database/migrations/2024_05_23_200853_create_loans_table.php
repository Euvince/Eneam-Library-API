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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->date(column : 'loan_date');
            $table->date(column : 'processing_date')->default(value : NULL);
            $table->integer(column : 'duration');
            $table->string(column : 'status');
            $table->integer(column : 'renewals');
            $table->string(column : 'created_by');
            $table->string(column : 'updated_by');
            $table->string(column : 'deleted_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
