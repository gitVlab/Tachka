<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advert extends Model
{
    use HasFactory;


    public const TRANSPORT_CATEGORY = 'transport';
    public const TIRES_CATEGORY = 'tires';
    public const SPARES_CATEGORY = 'spares';

    protected $fillable = [
        'customer_id',
        'type',
        'date_start',
        'date_end',
        'status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
