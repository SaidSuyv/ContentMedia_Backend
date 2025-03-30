<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'isbn',
        'name',
        'stock',
        'book_price',
        'created_at'
    ];
}
