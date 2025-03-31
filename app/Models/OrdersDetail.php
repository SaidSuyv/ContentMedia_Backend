<?php

namespace App\Models;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrdersDetail extends Model
{
    protected $fillable = [
        "order_id",
        "book_id",
        "detail_price",
        "quantity"
    ];

    /**
     * Get the user that owns the OrdersDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order_id()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function book_id()
    {
        return $this->belongsTo(Book::class,"book_id",'id');
    }
}
