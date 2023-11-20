<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function up(): void
    {
        Schema::table('bill_items', function (Blueprint $table) {
            $table->decimal('amount', 16, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bill_items', function (Blueprint $table) {
            //
        });
    }
};
