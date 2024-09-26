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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->references('id')->on('customers');
            $table->string('proposal')->nullable();
            $table->string('workorder')->nullable();
            $table->string('advance_amount_percentage')->nullable();
            $table->string('expected_gp_amount')->nullable();
            $table->foreignId('item_id')->nullable()->references('id')->on('items');
            $table->string('otc_amount')->nullable();
            $table->string('mrc_amount')->nullable();
            $table->string('yrc_amount')->nullable();
            $table->string('vat')->nullable();
            $table->date('comn_date')->nullable();
            $table->date('bill_start')->nullable();
            $table->foreignId('solution_id')->nullable()->references('id')->on('solutions');
            $table->bigInteger('quantity')->nullable();
            $table->longText('specification')->nullable();
            $table->longText('comment')->nullable();
            $table->foreignId('payment_type_id')->nullable()->references('id')->on('payment_types');
            $table->foreignId('sale_type_id')->nullable()->references('id')->on('sales_types');
            $table->boolean('is_active')->default(1);
            $table->foreignId('added_by')->nullable()->references('id')->on('users');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
