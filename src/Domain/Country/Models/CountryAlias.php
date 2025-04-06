<?php

namespace Domain\Country\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property Country $country
 */
class CountryAlias extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'country_id' => 'integer',
    ];

    /**
     * @return BelongsTo<Country, CountryAlias>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}