<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nombre del logro')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('Descripción')
                ->required()
                ->rows(3),

            Forms\Components\Select::make('type')
                ->label('Tipo')
                ->options([
                    'login_streak' => 'Racha de inicio de sesión',
                    'plans_created' => 'Planes creados',
                    'messages_sent' => 'Mensajes enviados',
                ])
                ->required(),

            Forms\Components\TextInput::make('target_value')
                ->label('Meta numérica')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('reward_type')
                ->label('Tipo de recompensa')
                ->options([
                    'swaps' => 'Cambios extra',
                    'regenerations' => 'Regeneraciones extra',
                ])
                ->nullable(),

            Forms\Components\TextInput::make('reward_amount')
                ->label('Cantidad de recompensa')
                ->numeric()
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable(),
            Tables\Columns\TextColumn::make('type')->badge(),
            Tables\Columns\TextColumn::make('target_value')->label('Meta'),
            Tables\Columns\TextColumn::make('reward_type')->label('Recompensa'),
            Tables\Columns\TextColumn::make('reward_amount')->label('Cantidad'),
            Tables\Columns\TextColumn::make('created_at')->label('Creado')->dateTime()->sortable(),
        ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
