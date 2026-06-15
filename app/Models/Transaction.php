<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'title', 'amount', 'type', 'category', 'date', 'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
