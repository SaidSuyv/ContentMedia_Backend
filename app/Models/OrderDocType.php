<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDocType extends Model
{
    protected $fillable = [
        "name",
        "digit_amount"
    ];
}
