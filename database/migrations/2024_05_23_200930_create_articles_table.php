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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string(column : 'type')->nullable()->default(value : "Livre");
            $table->string(column : 'title');
            $table->string(column : 'slug');
            $table->longText(column : 'summary');
            $table->string(column : 'author');
            $table->string(column : 'editor');
            $table->year(column : 'editing_year');
            $table->string(column : 'cote')->nullable()->default(value : NULL);
            $table->integer(column : 'number_pages')->nullable()->default(value : NULL);
            $table->string(column : 'ISBN')->nullable()->default(value : NULL);
            $table->unsignedBigInteger(column : 'available_stock')->nullable()->default(value : NULL);
            $table->boolean(column : 'available')->default(value : true);
            $table->boolean(column : 'loaned')->default(value : false);
            $table->boolean(column : 'reserved')->default(value : false);
            $table->boolean(column : 'has_ebooks')->default(value : false);
            $table->boolean(column : 'is_physical')->default(value : false);
            $table->boolean(column : 'has_audios')->default(value : false);
            $table->string('thumbnail_path')->nullable()->default(value : NULL);
            $table->string('file_path')->nullable()->default(value : NULL);
            /* $table->json('keywords')->nullable()->default(value : NULL);
            $table->json('formats')->nullable()->default(value : NULL); */
            $table->json('files_paths')->nullable()->default(value : NULL);
            $table->unsignedBigInteger(column : 'likes_number')->default(value : 0);
            $table->unsignedBigInteger(column : 'views_number')->default(value : 0);
            $table->unsignedInteger(column : 'stars_number')->default(value : 0);
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
        Schema::dropIfExists('articles');
    }
};
