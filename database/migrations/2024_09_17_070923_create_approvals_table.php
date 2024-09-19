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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->string('rel_id')->nullable();
            $table->string('rel_type')->nullable();
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('approve')->nullable();
            $table->string('note')->nullable();
            $table->foreignId('approved_by')->nullable()->references('id')->on('users');
            $table->foreignId('rejected_by')->nullable()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
