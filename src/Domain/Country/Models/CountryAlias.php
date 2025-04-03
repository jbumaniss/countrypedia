<?php

namespace Domain\Country\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $code
 * @property string $official_name
 * @property string $common_name
 * @property int $country_id
 * @property Country $country
 */
class CountryAlias extends Model
{
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