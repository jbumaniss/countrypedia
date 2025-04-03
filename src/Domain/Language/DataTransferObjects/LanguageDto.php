<?php

namespace Domain\Language\DataTransferObjects;

use Domain\Country\Models\Country;
use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class LanguageDto extends Data
{
    public function __construct(
        public string $code,
        public string $name,
    )
    {
    }
}