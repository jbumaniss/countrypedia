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
        return $this->orderBy('common_name');
    }

    public function findById(int $id): ?Country
    {
        return $this->with([
            'languages',
        ])
            ->find($id);
    }

    /**
     * @param ?string $search
     * @return CountryBuilder<Country>
     */
    public function filterBySearch(?string $search = null): self
    {
        return $this->when($search, function ($query) use ($search) {
            $query->whereHas('aliases', function ($query) use ($search) {
                $query->where('official', 'like', "%{$search}%")
                    ->orWhere('common', 'like', "%{$search}%");
            });
        });
    }

    public function findByRegion(int $regionId, ?int $exclude = null): self
    {
        return $this->where('sub_region_id', $regionId)
            ->when($exclude, function ($query) use ($exclude) {
                $query->where('id', '!=', $exclude);
            })
            ->orderBy('common_name');
    }

    public function calculateCountryRank(int $population): int
    {
        return $this->where('population', '>', $population)
            ->count() + 1;
    }
}