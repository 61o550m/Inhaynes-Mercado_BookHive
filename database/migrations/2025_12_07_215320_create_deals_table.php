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
    Schema::create('deals', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('buyer_id');
        $table->unsignedBigInteger('seller_id');
        $table->unsignedBigInteger('book_id');
        $table->decimal('offer_price', 10, 2)->nullable();
        $table->string('status')->default('pending'); // pending, accepted, completed
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
