<?php

namespace Domain\Country\DataTransferObjects;

use Domain\Language\DataTransferObjects\LanguageDto;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class CountryDto extends Data
{
    /**
     * @param  Collection<int, LanguageDto>  $languages
     * @param  Collection<int, CountryAliasDto>  $countryAliases
     */
    public function __construct(
        public string $commonName,
        public string $officialName,
        public string $countryCode,
        public int $population,
        public string $flag,
        public float $area,
        public string $region,
        public ?string $subRegion = null,
        public Collection $languages,
        public Collection $countryAliases,
    )
    {
    }

    public static function fromArray(array $country): CountryDto
    {
        $names = Arr::get($country, 'name');
        $commonName = Arr::get($names, 'common');
        $officialName = Arr::get($names, 'official');
        $countryCode = Arr::get($country, 'cca2');
        $population = Arr::get($country, 'population');
        $flag = Arr::get($country, 'flag');
        $area = Arr::get($country, 'area');
        $region = Arr::get($country, 'region');
        $subRegion = Arr::get($country, 'subregion');
        $languages = LanguageDto::collect(
            collect(Arr::get($country, 'languages'))->map(function ($language, $key) {
                return [
                    'code' => $key,
                    'name' => $language,
                ];
            })
        );
        $countryAliases = CountryAliasDto::collect(
            collect(Arr::get($country, 'translations'))->map(function ($translation, $key) {
                return [
                    'code' => $key,
                    'official' => Arr::get($translation, 'official'),
                    'common' => Arr::get($translation, 'common'),
                ];
            })
        );
        return new self(
            commonName: $commonName,
            officialName: $officialName,
            countryCode: $countryCode,
            population: $population,
            flag: $flag,
            area: $area,
            region: $region,
            subRegion: $subRegion,
            languages: $languages,
            countryAliases: $countryAliases,
        );
    }
}