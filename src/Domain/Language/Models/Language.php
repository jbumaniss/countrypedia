<?php

namespace Domain\Language\Models;

use Domain\Country\Models\Country;
use Domain\Language\Builders\LanguageBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property Collection<int, Country> $countries
 *
 * @method static LanguageBuilder<Language> query()
 */
class Language extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsToMany<Country, Language>
     */
    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'country_language');
    }

    /**
     * @param  Builder  $query
     * @return LanguageBuilder<Language>
     */
    public function newEloquentBuilder($query): LanguageBuilder
    {
        return new LanguageBuilder($query);
    }

}