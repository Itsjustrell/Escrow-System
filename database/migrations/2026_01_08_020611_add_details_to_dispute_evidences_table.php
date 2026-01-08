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
        Schema::table('dispute_evidences', function (Blueprint $table) {
            $table->foreignId('uploaded_by')->after('escrow_dispute_id')->constrained('users')->cascadeOnDelete();
            $table->text('description')->nullable()->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dispute_evidences', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['uploaded_by', 'description']);
        });
    }
};
