<?php

namespace Domain\Country\Builders;

use Domain\Country\Models\Country;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of Country
 *
 * @extends Builder<TModelClass>
 */
class CountryBuilder extends Builder
{
    /**
     * @return CountryBuilder<Country>
     */
    public function list(): self
    {
        return $this;
    }
}