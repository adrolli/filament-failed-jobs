<?php

namespace Amvisor\FilamentFailedJobs\Resources;

use Amvisor\FilamentFailedJobs\Models\FailedJob;
use Amvisor\FilamentFailedJobs\Resources\FailedJobsResource\Pages\ListFailedJobs;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use InvadersXX\FilamentJsoneditor\Forms\JSONEditor;
use Illuminate\Support\Facades\Artisan;

class FailedJobsResource extends Resource
{
	protected static ?string $model = FailedJob::class;

	protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

	protected static function getNavigationGroup(): ?string
	{
		return __(config('filament-failed-jobs.navigation-group', 'Jobs'));
	}

	protected static function getNavigationBadge(): ?string
	{
		return (string) FailedJob::query()->count();
	}

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				TextInput::make('uuid')->disabled()->columnSpan(4),
				TextInput::make('failed_at')->disabled(),
				TextInput::make('id')->disabled(),
				TextInput::make('connection')->disabled(),
				TextInput::make('queue')->disabled(),

				// make text a little bit smaller because often a complete Stack Trace is shown:
				TextArea::make('exception')->disabled()->columnSpan(4)->extraInputAttributes(['style' => 'font-size: 80%;']),
				JSONEditor::make('payload')->disabled()->columnSpan(4),
			])->columns(4);
	}

	public static function table(Table $table): Table
	{
		return $table
			->defaultSort('id', 'desc')
			->columns([
				TextColumn::make('id')->sortable()->searchable()->toggleable(),
				TextColumn::make('failed_at')->sortable()->searchable(false)->toggleable(),
				TextColumn::make('exception')
					->sortable()
					->searchable()
					->toggleable()
					->wrap()
					->limit(200)
					->tooltip(fn (FailedJob $record) => "{$record->failed_at} UUID: {$record->uuid}; Connection: {$record->connection}; Queue: {$record->queue};"),
				TextColumn::make('uuid')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
				TextColumn::make('connection')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
				TextColumn::make('queue')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
			])
			->filters([])
			->bulkActions([
				BulkAction::make('retry')
					->label('Retry')
					->requiresConfirmation()
					->action(function (Collection $records): void {
						foreach ($records as $record) {
							Artisan::call("queue:retry {$record->uuid}");
						}
						Notification::make()
							->title("{$records->count()} jobs have been pushed back onto the queue.")
							->success()
							->send();
					}),
			])
			->actions([
				DeleteAction::make('Delete'),
				ViewAction::make('View'),
				Action::make('retry')
					->label('Retry')
					->requiresConfirmation()
					->action(function (FailedJob $record): void {
						Artisan::call("queue:retry {$record->uuid}");
						Notification::make()
							->title("The job with uuid '{$record->uuid}' has been pushed back onto the queue.")
							->success()
							->send();
					}),
			]);
	}

	public static function getPages(): array
	{
		return [
			'index' => ListFailedJobs::route('/'),
		];
	}
}
