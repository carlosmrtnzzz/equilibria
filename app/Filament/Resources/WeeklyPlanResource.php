<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeeklyPlanResource\Pages;
use Filament\Tables\Columns\TextColumn;
use App\Models\WeeklyPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Textarea;

class WeeklyPlanResource extends Resource
{
    protected static ?string $model = WeeklyPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Textarea::make('meals_json')
                    ->label('Contenido del plan')
                    ->rows(12)
                    ->disabled() 
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Fecha de creación')
                    ->dateTime(),

                TextColumn::make('meals_json')
                    ->label('Contenido del plan')
                    ->limit(50) 
                    ->tooltip(fn($record) => $record->plan_json),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeeklyPlans::route('/'),
            'create' => Pages\CreateWeeklyPlan::route('/create'),
            'edit' => Pages\EditWeeklyPlan::route('/{record}/edit'),
        ];
    }
}
