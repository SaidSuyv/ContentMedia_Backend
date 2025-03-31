<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        "doc_type",
        "doc_number",
        "first_name",
        "last_name",
        "phone",
        "email"
    ];

    /**
     * Get the user that owns the Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doc_type()
    {
        return $this->belongsTo(ClientDocType::class, 'doc_type', 'id');
    }
}
