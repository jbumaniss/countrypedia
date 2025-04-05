<?php

namespace Domain\Country\Models;

use Domain\Country\Builders\CountryBuilder;
use Domain\Language\Models\Language;
use Domain\Region\Models\Region;
use Domain\Region\Models\SubRegion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * @property int $id
 * @property string $common_name
 * @property string $official_name
 * @property string $country_code
 * @property int $population
 * @property string $flag
 * @property float $area
 * @property int $region_id
 * @property int $sub_region_id
 * @property Region $region
 * @property SubRegion $subRegion
 */
class Country extends Model
{
    protected $guarded = [];

    protected $casts = [
        'population' => 'integer',
        'area' => 'float',
    ];

    /**
     * @param  Builder  $query
     * @return CountryBuilder<Country>
     */
    public function newEloquentBuilder($query): CountryBuilder
    {
        return new CountryBuilder($query);
    }

    /**
     * @return BelongsTo<Region, Country>
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return BelongsTo<Region, Country>
     */
    public function subRegion(): BelongsTo
    {
        return $this->belongsTo(SubRegion::class);
    }

    /**
     * @return BelongsToMany<Language, Country>
     */
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'country_language');
    }

    /**
     * @return HasMany<CountryAlias, Country>
     */
    public function aliases(): HasMany
    {
        return $this->hasMany(CountryAlias::class, 'country_id', 'id');
    }
}