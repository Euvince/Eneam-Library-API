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
        Schema::create('supported_memories', function (Blueprint $table) {
            $table->id();
            $table->string(column : 'theme');
            $table->string(column : 'slug');
            $table->time(column : 'soutenance_hour');
            $table->string(column : 'first_author_name');
            $table->string(column : 'second_author_name');
            $table->string(column : 'first_author_email');
            $table->string(column : 'second_author_email');
            $table->string(column : 'first_author_phone');
            $table->string(column : 'second_author_phone');
            $table->string(column : 'jury_president');
            $table->string(column : 'memory_master');
            $table->string(column : 'file_path')->nullable()->default(value : NULL);
            $table->string(column : 'cover_page_path')->nullable()->default(value : NULL);
            $table->string(column : 'cote')->nullable()->default(value : NULL);
            $table->string(column : 'status')->default(value : "Invalidé");
            $table->string(column : 'created_by')->nullable()->default(value : NULL);
            $table->string(column : 'updated_by')->nullable()->default(value : NULL);
            $table->string(column : 'deleted_by')->nullable()->default(value : NULL);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supported_memories');
    }
};
