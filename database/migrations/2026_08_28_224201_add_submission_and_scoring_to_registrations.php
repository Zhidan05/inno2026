<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('submission_file_path')->nullable()->after('proof_of_payment');
            $table->string('submission_link')->nullable()->after('submission_file_path');
            $table->timestamp('submitted_at')->nullable()->after('submission_link');
            $table->unsignedBigInteger('scored_by')->nullable()->after('grade');
            $table->foreign('scored_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['scored_by']);
            $table->dropColumn(['submission_file_path', 'submission_link', 'submitted_at', 'scored_by']);
        });
    }
};
