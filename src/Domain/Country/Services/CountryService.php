<?php

namespace Domain\Country\Services;

use Domain\Country\Models\Country;
use Illuminate\Support\Collection;

class CountryService
{
    /**
     * @return Collection<int, Country>
     */
    public function list(): Collection
    {
        return Country::query()->list()->get();
    }

    public function show(int $id): Country
    {
        return Country::query()
            ->find($id);
    }
}