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
    Schema::create('offers', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('buyer_id');
        $table->unsignedBigInteger('seller_id');
        $table->unsignedBigInteger('book_id');

        $table->decimal('amount', 10, 2);
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');

        $table->timestamps();

        $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
