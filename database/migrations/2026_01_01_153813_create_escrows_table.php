<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('escrows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('amount', 15, 2);
            $table->string('status'); // created, funded, shipping, delivered, released, disputed, refunded
            $table->unsignedInteger('confirmation_window'); // hari
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('confirm_deadline')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escrows');
    }
};
