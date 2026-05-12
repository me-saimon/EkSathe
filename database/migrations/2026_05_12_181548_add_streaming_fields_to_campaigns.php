<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('campaigns', function (Blueprint $table) {
        $table->boolean('is_live')->default(false);
        $table->string('stream_key')->nullable()->unique(); // Unique key for the streamer
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            //
        });
    }
};
