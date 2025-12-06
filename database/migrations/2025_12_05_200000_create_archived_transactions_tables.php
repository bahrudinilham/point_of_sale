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
        // Create archived_transactions table (mirrors transactions table)
        Schema::create('archived_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_id')->index(); // Original transaction ID
            $table->string('invoice_number')->index();
            $table->unsignedBigInteger('user_id');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('final_amount', 12, 2);
            $table->decimal('cash_received', 12, 2);
            $table->decimal('change_amount', 12, 2);
            $table->unsignedBigInteger('payment_method_id');
            $table->timestamp('transaction_date');
            $table->timestamp('archived_at')->useCurrent(); // When it was archived
            $table->timestamps();
            
            // Store user name and payment method name for historical reference
            // (in case the original records are deleted)
            $table->string('user_name')->nullable();
            $table->string('payment_method_name')->nullable();
        });

        // Create archived_transaction_items table (mirrors transaction_items table)
        Schema::create('archived_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_id'); // Original item ID
            $table->foreignId('archived_transaction_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->text('note')->nullable();
            $table->timestamps();
            
            // Store product name for historical reference
            $table->string('product_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_transaction_items');
        Schema::dropIfExists('archived_transactions');
    }
};
