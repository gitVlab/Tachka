<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int                  $id
 * @property int                  $age
 * @property string               $type
 * @property string               $mark
 * @property string               $model
 * @property string               $transmission
 * @property string               $engine_type
 * @property string               $drive_type
 * @property numeric              $cost
 * @property-read Customer        $customer
 */

class Transport extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'transport';

    /** @var string[] */
    public const TYPES = [
        'легковой',
        'грузовой',
    ];

    /** @var string[] */
    public const MARKS = [
        'bmw',
        'audi',
        'mersedes',
        'reanult',
        'porsche',
    ];

    public const TRANSMISSIONS = [
        'автомат',
        'механика',
    ];

    public const ENGINE_TYPES = [
        'бензин',
        'дизель',
        'газ',
    ];

    public const DRIVE_TYPES = [
        'передний',
        'задний',
        'полный',
    ];

    protected $fillable = [
        'type',
        'mark',
        'model',
        'cost',
        'transmission',
        'age',
        'engine_type',
        'drive_type',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function advert(): HasMany
    {
        return $this->hasMany(Advert::class, 'customer_id', 'id');
    }
}
