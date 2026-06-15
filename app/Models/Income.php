<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'user_id', 'title', 'amount', 'source', 'date', 'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
