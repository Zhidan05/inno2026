<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->string('registration_type')->default('individual_or_team')->after('description');
            $table->integer('max_team_members')->default(1)->after('registration_type');
        });
    }

    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn(['registration_type', 'max_team_members']);
        });
    }
};
