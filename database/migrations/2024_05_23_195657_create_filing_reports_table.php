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
        Schema::create('filing_reports', function (Blueprint $table) {
            $table->id();
            $table->longText(column : 'observation');
            $table->string(column : 'created_by')->default(value : NULL);
            $table->string(column : 'updated_by')->default(value : NULL);
            $table->string(column : 'deleted_by')->default(value : NULL);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filing_reports');
    }
};
