<?php

namespace Domain\Country\DataTransferObjects;

use Domain\Country\Models\Country;
use Domain\Language\DataTransferObjects\LanguageDto;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class CountryTranslationDto extends Data
{
    public function __construct(
        public string $code,
        public string $official,
        public string $common,
    )
    {
    }
}