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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('itemname', '40');
            $table->string('image', '200')->nullable();
            $table->integer('price');
            $table->text('presentation')->nullable();
            $table->string('state', '100')->nullable();
            $table->tinyInteger('sell_flg')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
