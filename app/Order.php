<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_mobile',
        'user_id',
        'status',
        'reference',
        'requestId',
        'processUrl',
        'total',
    ];
    // scopes

    public function scopeByUser($query)
    {
        $user_id = auth()->id();

        return $query->when($user_id, function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        });
    }
}
