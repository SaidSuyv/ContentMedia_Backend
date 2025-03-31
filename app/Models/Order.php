<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "client_id",
        "total",
        "doc_type",
        "doc_number"
    ];
    public function client_id()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function doc_type()
    {
        return $this->belongsTo(OrderDocType::class,'doc_type','id');
    }
}
