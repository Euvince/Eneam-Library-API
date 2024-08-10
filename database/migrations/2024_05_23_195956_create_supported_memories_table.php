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
            $table->time(column : 'start_at');
            $table->time(column : 'ends_at');
            $table->string(column : 'first_author_matricule');
            $table->string(column : 'second_author_matricule')->nullable()->default(value : NULL);
            $table->string(column : 'first_author_firstname');
            $table->string(column : 'second_author_firstname')->nullable()->default(value : NULL);
            $table->string(column : 'first_author_lastname');
            $table->string(column : 'second_author_lastname')->nullable()->default(value : NULL);
            $table->string(column : 'first_author_email');
            $table->string(column : 'second_author_email')->nullable()->default(value : NULL);
            $table->string(column : 'first_author_phone');
            $table->string(column : 'second_author_phone')->nullable()->default(value : NULL);
            $table->string(column : 'jury_president_name');
            $table->string(column : 'memory_master_name');
            $table->string(column : 'memory_master_email')->nullable()->default(value : NULL);
            $table->string(column : 'cote')->nullable()->default(value : NULL);
            $table->string(column : 'status')->default(value : "Invalidé");
            $table->dateTime(column : 'validated_at')->nullable()->default(value : NULL);
            $table->dateTime(column : 'rejected_at')->nullable()->default(value : NULL);
            $table->string(column : 'file_path')->nullable()->default(value : NULL);
            $table->string(column : 'cover_page_path')->nullable()->default(value : NULL);
            $table->integer(column : 'views_number')->nullable()->default(value : NULL);
            $table->integer(column : 'download_number')->nullable()->default(value : NULL);
            $table->integer(column : 'printed_number')->nullable()->default(value : NULL);
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
