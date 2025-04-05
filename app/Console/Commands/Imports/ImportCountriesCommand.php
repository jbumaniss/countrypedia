<?php

namespace App\Console\Commands\Imports;

use Domain\Country\Actions\CountryImportAction;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Throwable;

class ImportCountriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import countries data from the Rest Countries API';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Fetching countries data from API...');
        try {
            $result = resolve(CountryImportAction::class)->execute();
            $this->info($result);
        } catch (ConnectionException|Throwable $e) {
            $this->error('Error fetching countries data: ' . $e->getMessage());
            return CommandAlias::FAILURE;
        }

        return CommandAlias::SUCCESS;
    }
}
