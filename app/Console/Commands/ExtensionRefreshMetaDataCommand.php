<?php

namespace App\Console\Commands;

use App\Extension;
use App\Jobs\FetchPackageMetaDataFromNpmJsRegistry;
use App\Jobs\UpdateExtensionModelFromJson;
use Illuminate\Console\Command;

class ExtensionRefreshMetaDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extension:refresh {name? : The name of the package }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the data from the NpmJS registry.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Extension::when($this->argument('name'), function ($query) {
            return $query->where('name', $this->argument('name'));
        })
        ->orderBy('name')
        ->chunk(10, function ($extensions) {
            $extensions->each(function ($extension) {
                $this->comment("Processing: {$extension->name}");
                FetchPackageMetaDataFromNpmJsRegistry::dispatch($extension->name);
            });
        });

        $this->info('Jobs to download fresh meta data from the registry created successfully.');
    }
}
