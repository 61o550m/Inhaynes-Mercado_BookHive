<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\ChatRoom;
use App\Models\User;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
 public function index()
{
    $rooms = ChatRoom::whereNotNull('book_id')   // ← hide rooms with no book
        ->where(function($q){
            $q->where('user1_id', auth()->id())
              ->orWhere('user2_id', auth()->id());
        })
        ->with(['user1','user2','book','messages'])
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('messages.chat-master', [
        'rooms' => $rooms,
        'currentRoom' => null,
        'otherUser' => null
    ]);
}



    public function openRoom($roomId)
    {
        $rooms = ChatRoom::where(function($q){
            $q->where('user1_id', auth()->id())
              ->orWhere('user2_id', auth()->id());
        })
        ->with(['user1','user2','book','messages.sender'])
        ->orderBy('updated_at', 'desc')
        ->get();

        $currentRoom = ChatRoom::with(['messages.sender','book','user1','user2'])
            ->findOrFail($roomId);

        $otherUser = ($currentRoom->user1_id == auth()->id())
            ? $currentRoom->user2
            : $currentRoom->user1;

        return view('messages.chat-master', compact('rooms','currentRoom','otherUser'));
    }


    public function startChat($userId, Request $request)
    {
        $bookId = $request->book_id;

$existing = ChatRoom::where(function($q) use ($userId, $bookId) {
        $q->where('user1_id', Auth::id())
          ->where('user2_id', $userId)
          ->where('book_id', $bookId);
    })
    ->orWhere(function($q) use ($userId, $bookId) {
        $q->where('user1_id', $userId)
          ->where('user2_id', Auth::id())
          ->where('book_id', $bookId);
    })
    ->first();


        if (!$existing) {
            $existing = ChatRoom::create([
                'user1_id' => Auth::id(),
                'user2_id' => $userId,
                'book_id' => $bookId
            ]);
        }

        return redirect()->route('messages.room', $existing->id);
    }


    public function fetch($roomId)
    {
        return Message::where('chat_room_id', $roomId)
            ->with('sender')
            ->orderBy('created_at')
            ->get();
    }

public function start($sellerId, $bookId = null)
{
    $buyerId = auth()->id();

    // look for an existing room with same buyer/seller + SAME BOOK
    $room = ChatRoom::where(function ($q) use ($buyerId, $sellerId) {
                $q->where('user1_id', $buyerId)->where('user2_id', $sellerId);
            })
            ->orWhere(function ($q) use ($buyerId, $sellerId) {
                $q->where('user1_id', $sellerId)->where('user2_id', $buyerId);
            })
            ->when($bookId, fn($q) => $q->where('book_id', $bookId))
            ->first();

    // if no room, create one
    if (!$room) {
        $room = ChatRoom::create([
            'user1_id' => $buyerId,
            'user2_id' => $sellerId,
            'book_id' => $bookId, // <-- IMPORTANT
        ]);
    }

    return redirect()->route('messages.room', $room->id);
}

    /* -----------------------------------
       SEND TEXT MESSAGE
    ----------------------------------- */
    public function send(Request $request)
    {
        $data = $request->json()->all();

        $room = ChatRoom::findOrFail($data['room_id']);

        // Determine receiver
        $receiverId = ($room->user1_id == Auth::id())
            ? $room->user2_id
            : $room->user1_id;

        if (!$receiverId) {
            $receiverId = $room->user1_id ?: $room->user2_id;
        }

        return Message::create([
            'chat_room_id' => $data['room_id'],
            'sender_id'    => Auth::id(),
            'receiver_id'  => $receiverId,
            'book_id'      => $room->book_id,
            'message'      => $data['message'],
            'type'         => 'text'
        ]);
    }


    /* -----------------------------------
       BUYER SENDS OFFER
    ----------------------------------- */
    public function sendOffer(Request $request)
    {
        $data = $request->json()->all();

        $room = ChatRoom::findOrFail($data['room_id']);

        $receiverId = ($room->user1_id == Auth::id())
            ? $room->user2_id
            : $room->user1_id;

        if (!$receiverId) {
            $receiverId = $room->user1_id ?: $room->user2_id;
        }

        return Message::create([
            'chat_room_id' => $data['room_id'],
            'sender_id'    => Auth::id(),
            'receiver_id'  => $receiverId,
            'book_id'      => $room->book_id,
            'message'      => 'Offered ₱' . number_format($data['offer_price'], 2),
            'type'         => 'offer',
            'offer_price'  => $data['offer_price']
        ]);
    }


    /* -----------------------------------
       SELLER ACCEPTS OFFER
    ----------------------------------- */
public function acceptOffer(Request $request)
{
    $data = $request->json()->all();

    $room = ChatRoom::findOrFail($data['room_id']);

    // Identify buyer and seller based on offer context
    $sellerId = Auth::id();
    $buyerId  = ($room->user1_id == $sellerId)
                ? $room->user2_id
                : $room->user1_id;

    // Create accepted message
    Message::create([
        'chat_room_id' => $room->id,
        'sender_id'    => $sellerId,
        'receiver_id'  => $buyerId,
        'book_id'      => $room->book_id,
        'message'      => 'Accepted offer ₱' . number_format($data['offer_price'], 2),
        'type'         => 'accepted',
        'offer_price'  => $data['offer_price']
    ]);

    // CREATE DEAL PROPERLY
    Deal::create([
        'buyer_id'  => $buyerId,
        'seller_id' => $sellerId,
        'book_id'   => $room->book_id,
        'price'     => $data['offer_price'],
        'status'    => 'Completed'
    ]);

    // Mark the book as SOLD
$room->book->update([
    'is_sold' => true
]);


    return response()->json(['success' => true]);
}

}