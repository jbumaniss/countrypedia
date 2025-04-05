<?php

namespace Domain\Language\Services;

use Domain\Language\Models\Language;

class LanguageService
{

    public function show(int $id): ?Language
    {
        return Language::query()
            ->findById($id);
    }
}