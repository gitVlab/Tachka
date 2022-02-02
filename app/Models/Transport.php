<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transport extends Model implements TransportInterface
{
    use HasFactory;

    /** @var string[] */
    public const MARKS = [
        'bmw',
        'audi',
        'mersedes',
        'reanult',
        'porsche',
    ];

    protected $fillable = [
        'type',
        'mark',
        'model',
        'cost',
        'user_id'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'transport_id', 'id');
    }

    public function createTransport(Model $instance): Model
    {
        // TODO: Implement createTransport() method.
    }
}
