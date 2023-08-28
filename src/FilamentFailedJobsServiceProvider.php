<?php

namespace Amvisor\FilamentFailedJobs;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Amvisor\FilamentFailedJobs\Resources\FailedJobsResource;
use Amvisor\FilamentFailedJobs\Resources\JobBatchesResource;
use Illuminate\Support\Facades\Schema;

class FilamentFailedJobsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-failed-jobs');

		$this->publishes([
            __DIR__ . '/../config/filament-failed-jobs.php' => config_path('filament-failed-jobs.php'),
        ], 'filament-failed-jobs');

		if (!app()->runningInConsole() && Schema::hasTable('job_batches')) {
			$this->resources[] = JobBatchesResource::class;
		}
	}
}
