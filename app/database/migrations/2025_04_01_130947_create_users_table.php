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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', '40');
            $table->string('email', '30');
            $table->string('password', '30');
            $table->string('remember_token', '100')->nullable();
            $table->string('image', 200)->nullable()->default('icons/no_image/no_image_square.jpg');
            $table->text('profile')->nullable();
            $table->string('name', '50')->nullable();
            $table->string('tel', 15)->nullable();
            $table->integer('postcode')->nullable();
            $table->string('address', '100')->nullable();
            $table->tinyInteger('user_flg')->default(1);
            $table->tinyInteger('del_fig')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
