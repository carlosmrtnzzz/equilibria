<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatMessageResource\Pages;
use App\Filament\Resources\ChatMessageResource\RelationManagers;
use App\Models\ChatMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChatMessageResource extends Resource
{
    protected static ?string $model = ChatMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('role')
                ->options([
                    'user' => 'Usuario',
                    'assistant' => 'Asistente',
                ])
                ->required(),

            Forms\Components\Textarea::make('content')
                ->required()
                ->rows(6),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('user.name')->label('Usuario')->searchable(),
            Tables\Columns\BadgeColumn::make('role')->colors([
                'user' => 'gray',
                'assistant' => 'emerald',
            ]),
            Tables\Columns\TextColumn::make('content')->limit(50)->wrap(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListChatMessages::route('/'),
            'create' => Pages\CreateChatMessage::route('/create'),
            'edit' => Pages\EditChatMessage::route('/{record}/edit'),
        ];
    }
}
