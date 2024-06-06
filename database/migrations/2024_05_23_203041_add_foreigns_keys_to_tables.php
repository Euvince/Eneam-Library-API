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
        Schema::table(table : 'soutenances', callback : function (Blueprint $table) {
            $table->foreignIdFor(model : App\Models\Cycle::class, column : 'cycle_id')
                ->nullable()
                ->default(value : NULL);
        });
        Schema::table(table : 'supported_memories', callback : function (Blueprint $table) {
            $table->foreignIdFor(model : App\Models\Sector::class, column : 'sector_id')
                ->nullable()
                ->default(value : NULL);
            $table->foreignIdFor(model : App\Models\Soutenance::class, column : 'soutenance_id')
                ->nullable()
                ->default(value : NULL);
        });
        Schema::table(table : 'filing_reports', callback : function (Blueprint $table) {
            $table->foreignIdFor(model : App\Models\SupportedMemory::class, column : 'supported_memory_id')
                ->nullable()
                ->default(value : NULL);
        });

        foreach (['roles'/* , 'permissions' */] as $tableName) {
            Schema::table(table : $tableName, callback : function (Blueprint $table) {
                $table->foreignIdFor(model : App\Models\RoleType::class, column : 'role_type_id')
                    ->nullable()
                    ->default(value : NULL);
            });
        }

        Schema::create(table : 'roletype_has_permission', callback : function (Blueprint $table) {
            $table->foreignIdFor(model : App\Models\Reservation::class, column : 'permission_id');
            $table->foreignIdFor(model : App\Models\RoleType::class, column : 'role_type_id');
            $table->primary(columns : ['permission_id', 'role_type_id']);
        });

        Schema::table(table : 'comments', callback : function (Blueprint $table) {
            $table->foreignIdFor(model : App\Models\Article::class, column : 'article_id')
                ->nullable()
                ->default(value : NULL);
        });

        foreach (['payments', 'subscriptions', 'comments', 'loans', 'reservations'] as $tableName) {
            Schema::table($tableName, callback : function (Blueprint $table) {
                $table->foreignIdFor(model : App\Models\User::class, column : 'user_id')
                    ->nullable()
                    ->default(value : NULL);
            });
        }

        Schema::create(table : 'article_loan', callback : function (Blueprint $table) {
            $table->foreignIdFor(model : App\Models\Article::class, column : 'article_id');
            $table->foreignIdFor(model : App\Models\Loan::class, column : 'loan_id');
            $table->integer(column : 'number_copies')/* ->after(column : 'loan_id') */;
            $table->primary(columns : ['article_id', 'loan_id']);
        });
        Schema::create(table : 'article_reservation', callback : function (Blueprint $table) {
            $table->foreignIdFor(model : App\Models\Article::class, column : 'article_id');
            $table->foreignIdFor(model : App\Models\Reservation::class, column : 'reservation_id');
            $table->primary(columns : ['article_id', 'reservation_id']);
        });

        Schema::table(table : 'sectors', callback : function (Blueprint $table) {
            $table->foreignIdFor(model : App\Models\Sector::class, column : 'sector_id')
                ->nullable()
                ->default(value : NULL)
                /* ->after('likes_number') */;
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(table : 'soutenances', callback : function (Blueprint $table) {
            $table->dropColumn(columns : ['cycle_id']);
        });
        Schema::table(table : 'supported_memories', callback : function (Blueprint $table) {
            $table->dropColumn(columns : ['soutenance_id', 'sector_id']);
        });
        Schema::table(table : 'filing_reports', callback : function (Blueprint $table) {
            $table->dropColumn(columns : ['supported_memory_id']);
        });

        foreach (['roles', 'permissions'] as $tableName) {
            Schema::table($tableName, callback : function (Blueprint $table) {
                $table->dropColumn(columns : ['role_type_id']);
            });
        }

        Schema::table(table : 'comments', callback : function (Blueprint $table) {
            $table->dropColumn(columns : ['article_id']);
        });

        foreach (['payments', 'subscriptions', 'comments', 'loans', 'reservations'] as $tableName) {
            Schema::table(table : $tableName, callback : function (Blueprint $table) {
                $table->dropColumn(columns : ['user_id']);
            });
        }

    }
};
