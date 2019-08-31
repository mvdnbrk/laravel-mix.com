<?php

namespace App\Console\Commands;

use App\Extension;
use App\Jobs\FetchReadme;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Jobs\UpdateExtensionModelFromJson;
use App\Jobs\FetchPackageMetaDataFromNpmJsRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExtensionMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extension:make {name : The name of the package }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new extension for Laravel Mix.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        $validator = Validator::make(
            ['name' => $name],
            ['name' => 'unique:extensions'],
            ['unique' => 'This extension already exists.']
        );

        if ($validator->fails()) {
            collect($validator->errors()->all())->each(function ($error) {
                $this->error($error);
            });

            return 1;
        }

        if (! $this->fetchPackageMetaDataFromNpmJsRegistry($name)) {
            $this->error('Extension could not be found in the NpmJS registry.');

            return 1;
        }

        $extension = Extension::create([
            'name' => $name,
        ]);

        UpdateExtensionModelFromJson::dispatchNow($extension);

        $this->fetchReadme($extension);

        $this->callSilent('page-cache:clear', [
            'slug' => route('extensions.index', [], false),
        ]);

        $this->info('Extension added successfully!');
    }

    protected function fetchPackageMetaDataFromNpmJsRegistry($name)
    {
        return $this->task('Fetching package meta data from npmjs registry', function () use ($name) {
            try {
                FetchPackageMetaDataFromNpmJsRegistry::dispatchNow($name);

                return true;
            } catch (NotFoundHttpException $exception) {
                return false;
            }
        });
    }

    protected function fetchReadme($extension)
    {
        return $this->task('Fetching readme from the repository', function () use ($extension) {
            try {
                FetchReadme::dispatchNow($extension);

                return true;
            } catch (NotFoundHttpException $exception) {
                return false;
            }
        });
    }
}
