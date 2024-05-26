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
            $table->float(column : 'eneamien_subscribe_rising');
            $table->float(column : 'extern_subscribe_rising');
            $table->integer(column : 'subscription_expiration_delay');
            $table->float(column : 'student_debt_price');
            $table->float(column : 'teacher_debt_price');
            $table->integer(column : 'student_loan_delay');
            $table->integer(column : 'teacher_loan_delay');
            $table->integer(column : 'student_renewals_number');
            $table->integer(column : 'teacher_renewals_number');
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
        Schema::dropIfExists('configurations');
    }
};
