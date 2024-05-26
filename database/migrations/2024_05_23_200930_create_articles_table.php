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
            $table->string(column : 'title');
            $table->string(column : 'slug');
            $table->string(column : 'type');
            $table->longText(column : 'summary');
            $table->string(column : 'author');
            $table->string(column : 'editor');
            $table->year(column : 'editing_year');
            $table->string(column : 'cote');
            $table->integer(column : 'number_pages');
            $table->string(column : 'ISBN');
            $table->integer(column : 'available_stock');
            $table->boolean(column : 'available')->default(value : true);
            $table->boolean(column : 'loaned')->default(value : false);
            $table->boolean(column : 'reserved')->default(value : false);
            $table->boolean(column : 'hasEbook')->default(value : false);
            $table->boolean(column : 'hasPodcast')->default(value : false);
            $table->json('keywords')->default(value : NULL);
            $table->json('formats')->default(value : NULL);
            $table->json('access_paths')->default(value : NULL);
            $table->integer(column : 'likes_number')->default(value : 0);
            $table->integer(column : 'views_number')->default(value : 0);
            $table->integer(column : 'stars_number')->default(value : 0);
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
