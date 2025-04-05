<?php

namespace Domain\Language\Builders;

use Domain\Language\Models\Language;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of Language
 *
 * @extends Builder<TModelClass>
 */
class LanguageBuilder extends Builder
{
    /**
     * @param int $id
     * @return Language|null
     */
    public function findById(int $id): ?Language
    {
        return $this
        ->with([
        'countries',
    ])
        ->find($id);
    }
}