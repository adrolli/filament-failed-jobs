<?php

namespace Amvisor\FilamentFailedJobs\Resources;

use Amvisor\FilamentFailedJobs\FilamentJobsPlugin;
use Amvisor\FilamentFailedJobs\Models\Job;
use Amvisor\FilamentFailedJobs\Resources\JobsResource\Pages\ListJobs;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class JobsResource extends Resource
{
    protected static ?string $model = Job::class;

    public static function getNavigationBadge(): ?string
    {
        return FilamentJobsPlugin::get()->getNavigationCountBadge() ? number_format(static::getModel()::count()) : null;
    }

    public static function getModelLabel(): string
    {
        return FilamentJobsPlugin::get()->getLabel();
    }

    public static function getPluralModelLabel(): string
    {
        return FilamentJobsPlugin::get()->getPluralLabel();
    }

    public static function getNavigationLabel(): string
    {
        return Str::title(static::getPluralModelLabel()) ?? Str::title(static::getModelLabel());
    }

    public static function getNavigationGroup(): ?string
    {
        return FilamentJobsPlugin::get()->getNavigationGroup();
    }

    public static function getNavigationSort(): ?int
    {
        return FilamentJobsPlugin::get()->getNavigationSort();
    }

    public static function getBreadcrumb(): string
    {
        return FilamentJobsPlugin::get()->getBreadcrumb();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return FilamentJobsPlugin::get()->shouldRegisterNavigation();
    }

    public static function getNavigationIcon(): string
    {
        return FilamentJobsPlugin::get()->getNavigationIcon();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('job_id')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name')
                    ->maxLength(255),
                TextInput::make('queue')
                    ->maxLength(255),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('finished_at'),
                Toggle::make('failed')
                    ->required(),
                TextInput::make('attempt')
                    ->required(),
                Textarea::make('exception_message')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->badge()
                    ->label(__('filament-jobs-monitor::translations.status'))
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => __("filament-jobs-monitor::translations.{$state}"))
                    ->color(fn (string $state): string => match ($state) {
                        'running' => 'primary',
                        'succeeded' => 'success',
                        'failed' => 'danger',
                    }),
                TextColumn::make('name')
                    ->label(__('filament-jobs-monitor::translations.name'))
                    ->sortable(),
                TextColumn::make('queue')
                    ->label(__('filament-jobs-monitor::translations.queue'))
                    ->sortable(),
                TextColumn::make('progress')
                    ->label(__('filament-jobs-monitor::translations.progress'))
                    ->formatStateUsing(fn (string $state) => "{$state}%")
                    ->sortable(),
                // ProgressColumn::make('progress')->label(__('filament-jobs-monitor::translations.progress'))->color('warning'),
                TextColumn::make('started_at')
                    ->label(__('filament-jobs-monitor::translations.started_at'))
                    ->since()
                    ->sortable(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobs::route('/'),
        ];
    }
}
