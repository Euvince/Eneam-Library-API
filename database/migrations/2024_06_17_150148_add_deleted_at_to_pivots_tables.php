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
        Schema::table('article_loan', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('article_keyword', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('article_reservation', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_loan', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('article_keyword', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('article_reservation', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
