<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'condition',
        'price',
        'genre',
        'description',
        'photos', 
        'thumbnail',
        'is_sold',
    ];

 
    protected $casts = [
        'photos' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
public function wishlistedBy()
{
    return $this->hasMany(Wishlist::class);
}


}
