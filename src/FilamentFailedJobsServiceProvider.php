<?php

namespace Amvisor\FilamentFailedJobs;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentFailedJobsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-failed-jobs');

        $this->publishes([
            __DIR__.'/../config/filament-failed-jobs.php' => config_path('filament-failed-jobs.php'),
        ], 'filament-failed-jobs');

    }
}
