<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    public const TYPE_DECLARANT = 'declarant';

    protected $fillable = [
        'user_id',
        'email',
        'mobile_number',
        'status',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function transport(): HasOne
    {
        return $this->hasOne(Transport::class, 'customer_id', 'id');
    }

    public function customerProfile(): HasOne
    {
        return $this->hasOne(CustomerProfile::class, 'customer_id', 'id');
    }
}
