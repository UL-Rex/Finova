<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = [
        'user_id', 'title', 'type', 'total_amount', 'paid_amount', 'interest_rate', 'due_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
