<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('help_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->string('subject');
            $table->text('message');
            $table->string('location')->nullable();
            $table->string('contact_info');

            $table->enum('status', ['new','processing','resolved','closed'])
                  ->default('new');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('help_requests');
    }
};
