<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'book_id',
        'price',
        'status'
    ];

    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer() {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }
}
