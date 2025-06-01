<?php

namespace App\Filament\Resources\WeeklyPlanResource\Pages;

use App\Filament\Resources\WeeklyPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWeeklyPlans extends ListRecords
{
    protected static string $resource = WeeklyPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
