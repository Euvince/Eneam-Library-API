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
            $table->string(column : 'matricule');
            $table->string(column : 'firstname');
            $table->string(column : 'lastname');
            $table->string(column : 'slug');
            $table->string(column : 'email')->unique();
            $table->timestamp(column : 'email_verified_at')->nullable();
            $table->string(column : 'password');
            $table->rememberToken();
            $table->string(column : 'phone_number');
            $table->string(column : 'birth_date');
            $table->string(column : 'sex');
            $table->boolean(column : 'hasPaid')->default(value : false);
            $table->boolean(column : 'hasAccess')->default(value : false);
            $table->float(column : 'debt_price')->default(value : NULL);
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
        Schema::dropIfExists('users');
    }
};
