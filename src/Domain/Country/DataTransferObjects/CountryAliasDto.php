<?php

namespace Domain\Country\DataTransferObjects;

use Domain\Country\Models\Country;
use Domain\Language\DataTransferObjects\LanguageDto;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class CountryAliasDto extends Data
{
    public function __construct(
        public string $name,
    )
    {
    }
}