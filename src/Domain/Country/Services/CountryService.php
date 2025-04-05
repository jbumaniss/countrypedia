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
            ->get();
    }

    public function show(int $id): ?Country
    {
        return Country::query()
            ->find($id);
    }
}