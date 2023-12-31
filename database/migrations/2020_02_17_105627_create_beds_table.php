<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bed_type');
            $table->string('bed_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('charge');
            $table->boolean('is_available')->default(1);
            $table->timestamps();

            $table->foreign('bed_type')->references('id')->on('bed_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('beds');
    }
};
