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
        Schema::create('client_doc_type', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            
            // Adjuntando Client Doc Type
            $table->unsignedBigInteger("doc_type");
            $table->foreign("doc_type")->references('id')->on('client_doc_type');

            $table->string('doc_number',20);
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('phone',20);
            $table->string('email');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('clients');
      Schema::dropIfExists('client_doc_type');
    }
};
