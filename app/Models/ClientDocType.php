<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

class ClientDocType extends Model
{
    protected $fillable = ["name"];
    protected $hidden = ["created_at","updated_at"];
}
