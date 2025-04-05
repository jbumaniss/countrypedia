<?php

namespace Domain\Country\Actions;

use Domain\Country\DataTransferObjects\CountryAliasDto;
use Domain\Country\DataTransferObjects\CountryDto;
use Domain\Country\Models\Country;
use Domain\Language\DataTransferObjects\LanguageDto;
use Domain\Language\Models\Language;
use Domain\Region\Models\Region;
use Domain\Shared\Services\ApiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class CountryImportAction
{
    public function __construct(
        private readonly ApiService $apiService
    ) {
    }

    /**
     * @throws Throwable
     */
    public function execute(): string
    {
        try{
            $response = $this->apiService->countryResource()->list();
        } catch (ConnectionException $e) {
            $shortError = substr($e->getMessage(), 0, 100);
            Log::error('Failed to fetch countries data', [
                'exception' => $shortError,
            ]);
            return "Failed to fetch countries data. Error: {$shortError}";
        }

        $countriesData = $response->getData(true);

        $this->processCountriesData($countriesData);

        return "Countries imported successfully!";
    }

    /**
     * @param  array  $countriesData
     */
    private function processCountriesData(array $countriesData): void
    {
        /** @var Collection<int, CountryDto>$countriesDtos */
        $countriesDtos = collect($countriesData)->map(function ($country) {
            return CountryDto::fromArray($country);
        });

        $countriesDtos->each(function (CountryDto $countryDto) {
            $region = Region::query()->firstOrCreate([
                'name' => $countryDto->region,
            ]);

            $country = Country::query()->firstOrCreate([
                'common_name' => $countryDto->commonName,
                'official_name' => $countryDto->officialName,
                'country_code' => $countryDto->countryCode,
                'population' => $countryDto->population,
                'flag' => $countryDto->flag,
                'area' => $countryDto->area,
                'region_id' => $region->id,
            ]);

            $country->languages()->sync(
                $countryDto->languages->map(function (LanguageDto $languageDto) {
                    return Language::query()->updateOrCreate([
                        'code' => $languageDto->code,
                        'name' => $languageDto->name,
                    ]);
                })->pluck('id')
            );

            $countryDto->countryAliases->each(function (CountryAliasDto $countryAliasDto)
            use ($country) {
                $country->aliases()->updateOrCreate([
                    'country_id' => $country->id,
                    'code' => $countryAliasDto->code,
                ], [
                    'official' => $countryAliasDto->official,
                    'common' => $countryAliasDto->common,
                ]);
            });
        });
    }
}