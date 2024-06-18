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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->date('event_date');
            $table->time('event_time');
            $table->string('event_name');
            $table->string('event_description');
            $table->string('event_location');
            $table->string('event_address');
            $table->string('event_image');
            $table->string('event_organization');
            $table->string('event_contact');
            $table->enum('event_status', ['upcoming', 'past', 'ongoing'])->default('upcoming');
            $table->enum('submission_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
