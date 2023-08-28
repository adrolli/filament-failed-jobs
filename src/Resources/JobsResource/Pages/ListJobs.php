<?php

namespace Amvisor\FilamentFailedJobs\Resources\JobsResource\Pages;

use Amvisor\FilamentFailedJobs\Resources\JobsResource;
use Amvisor\FilamentFailedJobs\Resources\JobsResource\Widgets\JobStatsOverview;
use Filament\Resources\Pages\ListRecords;

class ListJobs extends ListRecords
{
    public static string $resource = JobsResource::class;

    public function getActions(): array
    {
        return [];
    }

    public function getHeaderWidgets(): array
    {
        return [
            JobStatsOverview::class,
        ];
    }

    public function getTitle(): string
    {
        return __('filament-jobs-monitor::translations.title');
    }
}
