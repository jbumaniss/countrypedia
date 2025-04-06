<?php

namespace Tests\App\Console\Commands\Imports;

use App\Console\Commands\Imports\ImportCountriesCommand;
use Domain\Country\Actions\CountryImportAction;
use Tests\TestCase;

class ImportCountriesCommandTest extends TestCase
{
    public function test_import_countries_command(): void
    {
        $this->mock(CountryImportAction::class, function ($mock) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn('Countries data imported successfully.');
        });
        $this->artisan('import:countries')
            ->expectsOutput('Fetching countries data from API...')
            ->expectsOutput('Countries data imported successfully.')
            ->assertExitCode(0);
    }

    public function test_command_signature(): void
    {
        $command = new ImportCountriesCommand();
        $this->assertEquals('import:countries', $command->getName());
    }

    public function test_import_countries_command_failure(): void
    {
        $this->mock(CountryImportAction::class, function ($mock) {
            $mock->shouldReceive('execute')
                ->once()
                ->andThrow(new \Exception('API connection error'));
        });
        $this->artisan('import:countries')
            ->expectsOutput('Fetching countries data from API...')
            ->expectsOutput('Error fetching countries data: API connection error')
            ->assertExitCode(1);
    }
}