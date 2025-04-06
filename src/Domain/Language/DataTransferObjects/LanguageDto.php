<?php

namespace Domain\Language\DataTransferObjects;

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