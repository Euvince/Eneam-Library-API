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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string(column : 'matricule')->nullable()->default(value : NULL);
            $table->string(column : 'firstname')->nullable()->default(value : NULL);
            $table->string(column : 'lastname')->nullable()->default(value : NULL);
            $table->string(column : 'slug')->nullable()->default(value : NULL);
            $table->string(column : 'email')->unique();
            $table->timestamp(column : 'email_verified_at')->nullable();
            $table->string(column : 'password');
            $table->string(column : 'phone_number')->nullable()->default(value : NULL);
            $table->string(column : 'birth_date')->nullable()->default(value : NULL);
            $table->string(column : 'sex')->nullable()->default(value : NULL);
            $table->string(column : 'profile_photo_path')->nullable()->default(value : NULL);
            $table->boolean(column : 'has_paid')->default(value : false);
            $table->boolean(column : 'has_access')->default(value : false);
            $table->float(column : 'debt_amount')->default(value : 0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
