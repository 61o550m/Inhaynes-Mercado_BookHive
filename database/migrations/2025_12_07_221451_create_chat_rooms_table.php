<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('chat_rooms', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user1_id');  // seller
        $table->unsignedBigInteger('user2_id');  // buyer
        $table->unsignedBigInteger('book_id')->nullable(); // optional book
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_rooms');
    }
};
