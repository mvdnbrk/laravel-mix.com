<?php

namespace App\Console\Commands;

use App\Extension;
use App\Jobs\FetchReadme;
use Illuminate\Console\Command;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExtensionFetchReadmeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extension:readme {name? : The name of the package }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the readme file for a package from the repository.';

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
                dispatch(new FetchReadme($extension));
            });
        });

        $this->info('Jobs to fetch the readme files from the repository created successfully.');
    }
}