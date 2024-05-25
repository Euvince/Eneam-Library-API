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
            $table->date(column : 'soutenance_date');
            $table->time(column : 'soutenance_hour');
            $table->string(column : 'first_author_name');
            $table->string(column : 'second_author_name');
            $table->string(column : 'first_author_email');
            $table->string(column : 'second_author_email');
            $table->string(column : 'first_author_phone');
            $table->string(column : 'second_author_phone');
            $table->string(column : 'jury_president');
            $table->string(column : 'memory_master');
            $table->string(column : 'file_path');
            $table->string(column : 'cote');
            $table->string(column : 'status');
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
        Schema::dropIfExists('supported_memories');
    }
};
