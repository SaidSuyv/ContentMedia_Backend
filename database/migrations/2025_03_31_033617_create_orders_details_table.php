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
        Schema::create('orders_details', function (Blueprint $table) {
            $table->id();
            // Link Order ID
            $table->unsignedBigInteger("order_id");
            $table->foreign("order_id")->references("id")->on("orders");
            // Link Book ID
            $table->unsignedBigInteger("book_id");
            $table->foreign("book_id")->references("id")->on("books")->onDelete("cascade");
            $table->decimal("detail_price",10,2);
            $table->integer("quantity");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_details');
    }
};
