<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('registration_mode')->default('team')->after('user_id');
            $table->string('team_name')->nullable()->change();
        });

        // Modify ENUM column in MySQL (Laravel string/enum modification is complex without DBAL, so we use raw SQL safely)
        DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'revision_required') DEFAULT 'pending'");

        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone']);
            $table->string('nim')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn('nim');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
        });

        DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");

        Schema::table('registrations', function (Blueprint $table) {
            $table->string('team_name')->nullable(false)->change();
            $table->dropColumn('registration_mode');
        });
    }
};
