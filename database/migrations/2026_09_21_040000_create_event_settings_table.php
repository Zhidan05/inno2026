<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_settings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('countdown_target_at')->nullable();
            $table->boolean('countdown_enabled')->default(true);
            $table->string('countdown_label', 100)->nullable()->default('EVENT COUNTDOWN');
            $table->timestamps();
        });

        // Seed the singleton record.
        DB::table('event_settings')->insert([
            'countdown_target_at' => null,
            'countdown_enabled' => true,
            'countdown_label' => 'EVENT COUNTDOWN',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_settings');
    }
};
