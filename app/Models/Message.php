<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;
use App\Models\ChatRoom;

class Message extends Model
{
    protected $fillable = [
        'chat_room_id',
        'sender_id',
        'receiver_id',
        'book_id',
        'message',
        'type',
        'offer_price'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function room()
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }
}
