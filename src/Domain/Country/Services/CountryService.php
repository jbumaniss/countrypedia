<?php

namespace Domain\Country\Services;

use Domain\Country\Models\Country;
use Illuminate\Support\Collection;

class CountryService
{
    /**
     * @return Collection<int, Country>
     */
    public function list(?string $search = null): Collection
    {
        return Country::query()
            ->list()
            ->filterBySearch($search)
            ->get();
    }

    public function show(int $id): ?Country
    {
        $country = Country::query()
            ->findById($id);

        if(!$country) {
            return null;
        }

        if(!empty($country->neighbors)) {
            $country->setRelation(
                'neighbours',
                Country::query()->findByNeighbors(
                    neighbors: $country->neighbors
                )
                    ->get()
            );
        }

        $rank = Country::query()
            ->calculateCountryRank($country->population);

        $country->setAttribute('population_rank', $rank);

        return $country;
    }
}