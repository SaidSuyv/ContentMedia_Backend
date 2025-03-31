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
        Schema::create('order_doc_types', function (Blueprint $table) {
          $table->id();
          $table->string('name',50);
          $table->integer('digit_amount');
          $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
          $table->id();

          // Link Client ID
          $table->unsignedBigInteger("client_id");
          $table->foreign("client_id")->references("id")->on("clients");
          // Link Order Doc Type ID
          $table->unsignedBigInteger("doc_type");
          $table->foreign("doc_type")->references("id")->on("order_doc_types");

          $table->decimal("total",10,2);
          $table->string("doc_number",20)->unique();

          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('orders');
      Schema::dropIfExists('order_doc_types');
    }
};
