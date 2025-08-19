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
            $table->unsignedBigInteger('user_id'); // Прив'язка до користувача
            $table->string('service_type'); // Тип послуги
            $table->text('description')->nullable(); // Опис роботи
            $table->json('images')->nullable(); // Зображення у форматі JSON
            $table->integer('price')->default(0); // Ціна (опціонально)
            $table->timestamps();

            // Зовнішній ключ
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
