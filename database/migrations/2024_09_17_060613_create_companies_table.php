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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('contract_name')->nullable();
            $table->string('contract_phone')->nullable();
            $table->string('contract_department')->nullable();
            $table->string('md_name')->nullable();
            $table->string('md_email')->nullable();
            $table->string('md_phone')->nullable();
            $table->string('chairman_name')->nullable();
            $table->string('chairman_email')->nullable();
            $table->string('chairman_phone')->nullable();
            $table->string('trade_license')->nullable();
            $table->longText('billing_info')->nullable();
            $table->longText('technician_info')->nullable();
            $table->boolean('is_active')->default(0);
            $table->string('approve_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
