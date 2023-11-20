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
        Schema::create('purchased_medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_medicines_id');
            $table->integer('medicine_id')->unsigned()->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->string('lot_no');
            $table->float('tax', 25, 2);
            $table->integer('quantity');
            $table->float('amount', 25, 2);
            $table->timestamps();
            $table->foreign('medicine_id')->references('id')->on('medicines')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('purchase_medicines_id')->references('id')->on('purchase_medicines')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchased_medicines');
    }
};
