<?php

namespace App\Console\Commands;

use App\Jobs\UpdateExtensionModelFromJson;
use App\Models\Extension;
use Illuminate\Console\Command;

class ExtensionUpdateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extension:db-update {name? : The name of the package }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the database with the data retrieved from the NpmJS registry.';

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
                UpdateExtensionModelFromJson::dispatch($extension);

                $this->comment("Processing: {$extension->name}");
            });
        });

        $this->info('Jobs to update the database are created successfully.');
    }
}
