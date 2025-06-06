<?php

namespace Domain\Country\Actions;

use Domain\Country\DataTransferObjects\CountryAliasDto;
use Domain\Country\DataTransferObjects\CountryDto;
use Domain\Country\DataTransferObjects\CountryTranslationDto;
use Domain\Country\Models\Country;
use Domain\Language\DataTransferObjects\LanguageDto;
use Domain\Language\Models\Language;
use Domain\Region\Models\Region;
use Domain\Region\Models\SubRegion;
use Domain\Shared\Services\ApiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
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
            $response = $this->fetchData();
        } catch (ConnectionException $e) {
            Log::error('Failed to fetch countries data', [
                'exception' => $e->getMessage(),
            ]);
            return 'Failed to fetch countries data. Error: ' . $e->getMessage();
        }

        $countriesData = $response->getData(true);

        if($response->status() !== 200) {
            Log::error('Failed to fetch countries data', [
                'response' => $response,
            ]);
            return 'Failed to fetch countries data. Error: ' . $response;
        }

        $countriesDtos = $this->processCountriesData($countriesData);
        $this->insertCountriesData($countriesDtos);

        return "Countries imported successfully!";
    }

    /**
     * @return Collection<int, CountryDto>
     */
    private function processCountriesData(array $countriesData): Collection
    {
        return collect($countriesData)->map(function ($country) {
            if(!is_array($country) || empty($country)) {
                return null;
            }
            return CountryDto::fromArray($country);
        })
            ->filter();
    }

    /**
     * @throws ConnectionException
     */
    private function fetchData(): JsonResponse
    {
        return $this->apiService->countryResource()->list();
    }

    /**
     * @param  Collection<int, CountryDto>  $countriesDtos
     */
    private function insertCountriesData(Collection $countriesDtos): void
    {
        $countriesDtos->each(function (CountryDto $countryDto) {
            $region = Region::query()->firstOrCreate([
                'name' => $countryDto->region,
            ]);
            $subRegion = null;
            if($countryDto->subRegion) {
                $subRegion = SubRegion::query()->firstOrCreate([
                    'region_id' => $region->id,
                    'name' => $countryDto->subRegion,
                ]);
            }

            $country = Country::query()->firstOrCreate([
                'common_name' => $countryDto->commonName,
                'official_name' => $countryDto->officialName,
                'country_code' => $countryDto->countryCode,
                'fifa' => $countryDto->fifa,
                'population' => $countryDto->population,
                'flag' => $countryDto->flag,
                'area' => $countryDto->area,
                'region_id' => $region->id,
                'sub_region_id' => $subRegion?->id,
                'neighbors' => $countryDto->borderAliases
            ]);

            $country->languages()->sync(
                $countryDto->languages->map(function (LanguageDto $languageDto) {
                    return Language::query()->updateOrCreate([
                        'code' => $languageDto->code,
                        'name' => $languageDto->name,
                    ]);
                })->pluck('id')
            );

            $countryDto->translations->each(function (
                CountryTranslationDto $translationDto
            )
                use ($country) {
                $country->translations()->updateOrCreate([
                    'country_id' => $country->id,
                    'code' => $translationDto->code,
                ], [
                    'official' => $translationDto->official,
                    'common' => $translationDto->common,
                ]);
            });
            $countryDto->aliases->each(function (CountryAliasDto $aliasDto)
            use ($country) {
                $country->aliases()->updateOrCreate([
                    'country_id' => $country->id,
                    'name' => $aliasDto->name
                ]);
            });
        });
    }
}