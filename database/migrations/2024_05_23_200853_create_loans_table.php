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
        $title = "Nouvelle demande pour emprunt";

        Schema::create('loans', function (Blueprint $table) use($title) {
            $table->id();
            $table->string(column : 'title')->default(value : $title);
            $table->string(column : 'slug')->default(value : \Illuminate\Support\Str::slug($title));
            $table->date(column : 'loan_date');
            $table->date(column : 'processing_date')->nullable()->default(value : NULL);
            $table->integer(column : 'duration');
            $table->string(column : 'status')->default(value : "En cours");
            $table->unsignedInteger(column : 'renewals')->default(value : 0);
            $table->dateTime(column : 'reniew_at')->nullable()->default(value : NULL);
            $table->date(column : 'book_must_returned_on')->nullable()->default(value : NULL);
            $table->dateTime(column : 'book_recovered_at')->nullable()->default(value : NULL);
            $table->dateTime(column : 'book_returned_at')->nullable()->default(value : NULL);
            $table->string(column : 'created_by')->nullable()->default(value : NULL);
            $table->string(column : 'updated_by')->nullable()->default(value : NULL);
            $table->string(column : 'deleted_by')->nullable()->default(value : NULL);
            $table->dateTime(column : 'withdraw_at')->nullable()->default(value : NULL);
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
