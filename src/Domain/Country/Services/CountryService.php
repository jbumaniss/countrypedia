<?php

namespace Domain\Country\Services;

use Domain\Country\Models\Country;

class CountryService
{
    public function list(): array
    {
        return Country::query()->list();
    }
}