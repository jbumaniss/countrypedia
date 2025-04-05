<?php

namespace Tests\Domain\Country\Actions;

use Domain\Country\Actions\CountryImportAction;
use Domain\Country\Models\Country;
use Domain\Country\Models\CountryAlias;
use Domain\Language\Models\Language;
use Domain\Region\Models\Region;
use Domain\Region\Models\SubRegion;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Throwable;

class CountryImportActionTest extends TestCase
{
    private CountryImportAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = resolve(CountryImportAction::class);
    }

    private function retrieveMockData(): array
    {
        return [
            [
                'name' => [
                    'common' => 'Grenada',
                    'official' => 'Grenada',
                    'nativeName' => [
                        'eng' => [
                            'official' => 'Grenada',
                            'common' => 'Grenada',
                        ],
                    ],
                ],
                'tld' => ['.gd'],
                'cca2' => 'GD',
                'population' => 112523,
                'flag' => '🇬🇩',
                'area' => 344,
                'region' => 'Americas',
                'subregion' => 'Caribbean',
                'languages' => [
                    'eng' => 'English',
                ],
                'translations' => [
                    'ara' => [
                        'official' => 'GrenadaA',
                        'common' => 'GrenadaA',
                    ],
                    'bre' => [
                        'official' => 'GrenadaB',
                        'common' => 'GrenadaB',
                    ],
                ],
            ],
            [
                'name' => [
                    'common' => 'South Georgia and the South Sandwich Islands',
                    'official' => 'South Georgia and the South Sandwich Islands',
                    'nativeName' => [
                        'eng' => [
                            'official' => 'South Georgia and the South Sandwich Islands',
                            'common' => 'South Georgia and the South Sandwich Islands',
                        ],
                    ],
                ],
                'tld' => ['.gs'],
                'cca2' => 'GS',
                'population' => 30,
                'flag' => '🇬🇸',
                'area' => 3903,
                'region' => 'Antarctic',
                'subregion' => '',
                'languages' => [
                    'eng' => 'English',
                ],
                'translations' => [
                    'ara' => [
                      'common' => "SouthA",
                      'official' => "SouthA",
                    ],
                    'bre' => [
                        'official' => 'SouthB',
                        'common' => 'SouthB',
                    ],
                ],
            ]
        ];
    }

    /**
     * @throws Throwable
     */
    public function test_it_can_import_countries(): void
    {
        $mockData = $this->retrieveMockData();
        Http::fake([
            'https://restcountries.com/v3.1/all' => Http::sequence()
                ->push($mockData),
        ]);

        $response = $this->action->execute();

        $this->assertStringContainsString('Countries imported successfully!', $response);

        $regionA = Region::query()->firstWhere('name', 'Americas');
        $subRegionA = Subregion::query()->firstWhere('name', 'Caribbean');
        $countryA = Country::query()->firstWhere('common_name', 'Grenada');
        $languageA = Language::query()->firstWhere('name', 'English');
        $countryAliasesA = CountryAlias::query()->where('country_id', $countryA->id)->get();

        $this->assertNotNull($regionA);
        $this->assertNotNull($subRegionA);
        $this->assertNotNull($countryA);
        $this->assertEquals('Grenada', $countryA->official_name);
        $this->assertEquals('Grenada', $countryA->common_name);
        $this->assertEquals('GD', $countryA->country_code);
        $this->assertEquals(112523, $countryA->population);
        $this->assertEquals('🇬🇩', $countryA->flag);
        $this->assertEquals(344, $countryA->area);
        $this->assertEquals($regionA->id, $countryA->region_id);
        $this->assertEquals($subRegionA->id, $countryA->sub_region_id);
        $this->assertEquals('Americas', $countryA->region->name);
        $this->assertEquals('Caribbean', $countryA->subRegion->name);
        $this->assertEquals('English', $languageA->name);
        $this->assertEquals('eng', $languageA->code);
        $this->assertEquals(1, $countryA->languages()->count());
        $this->assertEquals(2, $countryAliasesA->count());
        $countryAliasesA->each(function (CountryAlias $countryAlias) {
            $this->assertContains($countryAlias->official, ['GrenadaA', 'GrenadaB']);
        });

        $regionB = Region::query()->firstWhere('name', 'Antarctic');
        $countryB = Country::query()->firstWhere('common_name', 'South Georgia and the South Sandwich Islands');
        $languageB = Language::query()->firstWhere('name', 'English');
        $countryAliasesB = CountryAlias::query()->where('country_id', $countryB->id)->get();
        $this->assertNotNull($regionB);
        $this->assertNotNull($countryB);
        $this->assertEquals('South Georgia and the South Sandwich Islands', $countryB->official_name);
        $this->assertEquals('South Georgia and the South Sandwich Islands', $countryB->common_name);
        $this->assertEquals('GS', $countryB->country_code);
        $this->assertEquals(30, $countryB->population);
        $this->assertEquals('🇬🇸', $countryB->flag);
        $this->assertEquals(3903, $countryB->area);
        $this->assertEquals($regionB->id, $countryB->region_id);
        $this->assertNull($countryB->subRegion);
        $this->assertEquals('Antarctic', $countryB->region->name);
        $this->assertEquals('English', $languageB->name);
        $this->assertEquals('eng', $languageB->code);
        $this->assertEquals(1, $countryB->languages()->count());
        $this->assertEquals(2, $countryAliasesB->count());
        $countryAliasesB->each(function (CountryAlias $countryAlias) {
            $this->assertContains($countryAlias->official, ['SouthA', 'SouthB']);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_it_can_handle_api_failure(): void
    {
        Http::fake([
            'https://restcountries.com/v3.1/all' => Http::sequence()
                ->push(['error' => 'API error'], 500),
        ]);

        $response = $this->action->execute();

        $this->assertStringContainsString('Failed to fetch countries data', $response);
    }

    /**
     * @throws Throwable
     */
    public function test_it_can_handle_empty_response(): void
    {
        Http::fake([
            'https://restcountries.com/v3.1/all' => Http::sequence()
                ->push([]),
        ]);

        $response = $this->action->execute();

        $this->assertStringContainsString('Countries imported successfully!', $response);
    }

    /**
     * @throws Throwable
     */
    public function test_it_can_handle_invalid_data(): void
    {
        Http::fake([
            'https://restcountries.com/v3.1/all' => Http::sequence()
                ->push(['invalid' => 'data']),
        ]);

        $response = $this->action->execute();

        $this->assertStringContainsString('Countries imported successfully!', $response);
    }

    /**
     * @throws Throwable
     */
    public function test_it_can_handle_missing_subregion(): void
    {
        $mockData = [
            [
                'name' => [
                    'common' => 'Grenada',
                    'official' => 'Grenada',
                    'nativeName' => [
                        'eng' => [
                            'official' => 'Grenada',
                            'common' => 'Grenada',
                        ],
                    ],
                ],
                'tld' => ['.gd'],
                'cca2' => 'GD',
                'population' => 112523,
                'flag' => '🇬🇩',
                'area' => 344,
                'region' => 'Americas',
                'languages' => [
                    'eng' => 'English',
                ],
            ]
        ];
        Http::fake([
            'https://restcountries.com/v3.1/all' => Http::sequence()
                ->push($mockData),
        ]);

        $response = $this->action->execute();

        $this->assertStringContainsString('Countries imported successfully!', $response);
    }
}
//namespace Domain\Country\Actions;
//
//use Domain\Country\DataTransferObjects\CountryAliasDto;
//use Domain\Country\DataTransferObjects\CountryDto;
//use Domain\Country\Models\Country;
//use Domain\Language\DataTransferObjects\LanguageDto;
//use Domain\Language\Models\Language;
//use Domain\Region\Models\Region;
//use Domain\Region\Models\SubRegion;
//use Domain\Shared\Services\ApiService;
//use Illuminate\Http\Client\ConnectionException;
//use Illuminate\Http\JsonResponse;
//use Illuminate\Support\Collection;
//use Illuminate\Support\Facades\Log;
//use Throwable;
//
//class CountryImportAction
//{
//    public function __construct(
//        private readonly ApiService $apiService
//    ) {
//    }
//
//    /**
//     * @throws Throwable
//     */
//    public function execute(): string
//    {
//        try{
//            $response = $this->fetchData();
//        } catch (ConnectionException $e) {
//            Log::error('Failed to fetch countries data', [
//                'exception' => $e->getMessage(),
//            ]);
//            return 'Failed to fetch countries data. Error: ' . $e->getMessage();
//        }
//
//        $countriesData = $response->getData(true);
//
//        $countriesDtos = $this->processCountriesData($countriesData);
//        $this->insertCountriesData($countriesDtos);
//
//        return "Countries imported successfully!";
//    }
//
//    /**
//     * @return Collection<int, CountryDto>
//     */
//    private function processCountriesData(array $countriesData): Collection
//    {
//        return collect($countriesData)->map(function ($country) {
//            return CountryDto::fromArray($country);
//        });
//    }
//
//    /**
//     * @throws ConnectionException
//     */
//    private function fetchData(): JsonResponse
//    {
//        return $this->apiService->countryResource()->list();
//    }
//
//    /**
//     * @param  Collection<int, CountryDto>  $countriesDtos
//     */
//    private function insertCountriesData(Collection $countriesDtos): void
//    {
//        $countriesDtos->each(function (CountryDto $countryDto) {
//            $region = Region::query()->firstOrCreate([
//                'name' => $countryDto->region,
//            ]);
//            $subRegion = SubRegion::query()->firstOrCreate([
//                'region_id' => $region->id,
//                'name' => $countryDto->subRegion,
//            ]);
//
//            $country = Country::query()->firstOrCreate([
//                'common_name' => $countryDto->commonName,
//                'official_name' => $countryDto->officialName,
//                'country_code' => $countryDto->countryCode,
//                'population' => $countryDto->population,
//                'flag' => $countryDto->flag,
//                'area' => $countryDto->area,
//                'region_id' => $region->id,
//                'sub_region_id' => $subRegion->id,
//            ]);
//
//            $country->languages()->sync(
//                $countryDto->languages->map(function (LanguageDto $languageDto) {
//                    return Language::query()->updateOrCreate([
//                        'code' => $languageDto->code,
//                        'name' => $languageDto->name,
//                    ]);
//                })->pluck('id')
//            );
//
//            $countryDto->countryAliases->each(function (CountryAliasDto $countryAliasDto)
//            use ($country) {
//                $country->aliases()->updateOrCreate([
//                    'country_id' => $country->id,
//                    'code' => $countryAliasDto->code,
//                ], [
//                    'official' => $countryAliasDto->official,
//                    'common' => $countryAliasDto->common,
//                ]);
//            });
//        });
//    }
//}