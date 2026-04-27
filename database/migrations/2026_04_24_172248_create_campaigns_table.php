<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_by')->constrained('users')->cascadeOnDelete();

            $table->string('category'); // better later: FK
            $table->string('title');
            $table->text('description');
            $table->timestamp('campaign_date')->nullable();
            $table->decimal('goal_amount', 15, 2)->default(0);
            $table->string('live_video_url')->nullable();
            $table->string('address');
            $table->string('location_map', 1000)->nullable();
            $table->integer('rank')->default(0);
            $table->string('banner_image', 500);
            $table->boolean('is_volunteer_need')->default(0);

            $table->enum('status', ['active','completed','paused'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
