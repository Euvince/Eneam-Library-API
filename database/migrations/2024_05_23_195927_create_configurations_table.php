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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string(column : 'school_name');
            $table->string(column : 'school_acronym');
            $table->string(column : 'school_city');
            $table->string(column : 'archivist_full_name');
            $table->string(column : 'archivist_signature')->nullable();
            $table->decimal('eneamien_subscribe_amount', 15, 2);
            $table->decimal('extern_subscribe_amount', 15, 2);
            $table->unsignedBigInteger(column : 'subscription_expiration_delay');
            $table->decimal('student_debt_amount', 15, 2);
            $table->decimal('teacher_debt_amount', 15, 2);
            $table->unsignedBigInteger(column : 'student_loan_delay');
            $table->unsignedBigInteger(column : 'teacher_loan_delay');
            $table->unsignedBigInteger(column : 'student_recovered_delay');
            $table->unsignedBigInteger(column : 'teacher_recovered_delay');
            $table->unsignedBigInteger(column : 'student_renewals_number');
            $table->unsignedBigInteger(column : 'teacher_renewals_number');
            $table->unsignedBigInteger(column : 'max_books_per_student');
            $table->unsignedBigInteger(column : 'max_books_per_teacher');
            $table->unsignedBigInteger(column : 'max_copies_books_per_student');
            $table->unsignedBigInteger(column : 'max_copies_books_per_teacher');
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
        Schema::dropIfExists('configurations');
    }
};
