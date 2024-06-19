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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('news_title');
            $table->text('news_content');
            $table->string('news_image');
            $table->string('news_category');
            $table->unsignedBigInteger('news_edition');
            $table->foreign('news_edition')->references('id')->on('edtions')->onDelete('cascade');
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
        Schema::dropIfExists('news');
    }
};
