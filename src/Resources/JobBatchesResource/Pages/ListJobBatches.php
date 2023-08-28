<?php

namespace Amvisor\FilamentFailedJobs\Resources\JobBatchesResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Amvisor\FilamentFailedJobs\Resources\JobBatchesResource;

class ListJobBatches extends ListRecords
{
    protected static string $resource = JobBatchesResource::class;

    public function getActions(): array
    {
        return [
            Action::make('prune_batches')
                ->label('Prune all batches')
                ->requiresConfirmation()
                ->color('danger')
                ->action(function (): void {
                    Artisan::call('queue:prune-batches');
                    Notification::make()
                        ->title('All batches have been pruned.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
