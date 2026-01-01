<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escrow_disputes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('escrow_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('reason');

            $table->string('status'); 
            // open | resolved

            $table->foreignId('resolved_by')
                ->nullable()
                ->constrained('users');

            $table->string('resolution')
                ->nullable(); 
            // release | refund

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escrow_disputes');
    }
};
