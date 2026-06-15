<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'user_id', 'name', 'type', 'invested_amount', 'current_value', 'date', 'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
