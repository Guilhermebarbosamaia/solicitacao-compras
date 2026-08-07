<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordens_pagamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained('solicitacoes_compra')->cascadeOnDelete();
            $table->string('description');
            $table->string('payment_type');
            $table->decimal('total_amount', 12, 2);
            $table->date('due_date');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->index(['payment_type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordens_pagamento');
    }
};
