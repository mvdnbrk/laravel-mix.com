<?php

namespace App\Console\Commands;

use App\Models\Extension;
use App\Jobs\UpdateWeeklyDownloadCount;
use Illuminate\Console\Command;

class FetchDownloadCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extension:stats {name? : The name of the package }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the weekly download count for a package.';

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
                UpdateWeeklyDownloadCount::dispatch($extension);

                $this->comment("Processing: {$extension->name}");
            });
        });

        $this->info('Jobs to update the weekly download count are created successfully.');
    }
}
