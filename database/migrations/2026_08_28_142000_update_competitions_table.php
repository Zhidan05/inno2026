<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name')->nullable();
            $table->timestamp('registration_open_at')->nullable()->after('registration_fee');
            $table->timestamp('registration_close_at')->nullable()->after('registration_open_at');
            $table->timestamp('competition_start_at')->nullable()->after('registration_close_at');
            $table->timestamp('competition_end_at')->nullable()->after('competition_start_at');
            $table->string('location')->nullable()->after('competition_end_at');
            $table->string('status')->default('draft')->after('location');
            $table->dropColumn('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 
                'registration_open_at', 
                'registration_close_at', 
                'competition_start_at', 
                'competition_end_at', 
                'location', 
                'status'
            ]);
            $table->boolean('is_active')->default(true);
        });
    }
};
