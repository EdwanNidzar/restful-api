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
        Schema::create('bulletins', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('page_count');
            $table->string('cover_image');
            $table->string('url_bulletin');
            $table->enum('status', ['pending', 'approve', 'reject'])->default('pending');
            $table->enum('release_status', ['draft', 'published'])->default('draft');
            $table->string('notes')->nullable();

            $table->foreignId('edition_id')->on('edtions')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulletins');
    }
};
