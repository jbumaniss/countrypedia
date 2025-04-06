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
            $query->whereHas('translations', function ($query) use ($search) {
                $query->where('official', 'like', "%{$search}%")
                    ->orWhere('common', 'like', "%{$search}%");
            });
        });
    }

    public function findByFifaCodes(array $neighbors): self
    {
        return $this->whereIn('fifa', $neighbors)
            ->orderBy('common_name');
    }

    public function calculateCountryRank(int $population): int
    {
        return $this->where('population', '>', $population)
            ->count() + 1;
    }
}