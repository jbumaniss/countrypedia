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
                ->whereHas('aliases', function ($query) use ($search) {
                    $query->where('official', 'like', "%{$search}%")
                        ->orWhere('common', 'like', "%{$search}%");
                })
            ->orderBy('common_name')
            ->get();
    }

    public function show(int $id): ?Country
    {
        $country = Country::query()
            ->with([
                'languages',
            ])
            ->find($id);

        if(!$country) {
            return null;
        }

        $country->setRelation('neighbours', Country::query()
            ->where('sub_region_id', $country->sub_region_id)
            ->where('id', '!=', $country->id)
            ->orderBy('common_name')
            ->get());

        $rank = Country::query()
                ->where('population', '>', $country->population)
                ->count() + 1;

        $country->setAttribute('population_rank', $rank);

        return $country;
    }
}