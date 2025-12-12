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
    Schema::table('messages', function (Blueprint $table) {
        if (!Schema::hasColumn('messages', 'chat_room_id')) {
            $table->unsignedBigInteger('chat_room_id')->nullable()->after('offer_price');
        }
    });
}


    /**
     * Reverse the migrations.
     */
public function down()
{
    Schema::table('messages', function (Blueprint $table) {
        $table->dropColumn('chat_room_id');
    });
}

};
