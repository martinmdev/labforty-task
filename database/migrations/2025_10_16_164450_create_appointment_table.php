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
        Schema::create('appointment', function (Blueprint $table) {
            $table->id();
            $table->dateTime('timestamp');
            $table->string('names');
            $table->string('ucn'); // Unique citizenship number / ЕГН
            $table->text('description')->nullable();
            $table->unsignedBigInteger('notification_type_id');
            $table->timestamps();
            $table->foreign('notification_type_id')
                ->references('id')
                ->on('notification_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
    }
};
