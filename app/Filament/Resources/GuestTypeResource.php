<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestTypeResource\Pages;
use App\Filament\Resources\GuestTypeResource\RelationManagers;
use App\Domains\Guests\Models\GuestType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuestTypeResource extends Resource
{
    protected static ?string $model = GuestType::class;

    protected static ?string $navigationIcon = 'carbon-data-categorical';

    protected static ?string $navigationGroup = 'Guests';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255),
                        Forms\Components\Textarea::make('description')->columnSpanFull(),
                    ])
                    ->columns(['default' => 1, 'md' => 2])
                    ->columnSpan(1),
            ])
            ->columns([
                'default' => 1,
                'lg' => 2,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([Tables\Filters\TrashedFilter::make()])
            ->actions([Tables\Actions\ViewAction::make(), Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $list): Infolist
    {
        return $list
            ->schema([
                Infolists\Components\Fieldset::make('Guest type')
                    ->schema([
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('description'),
                    ])
                    ->columns(['default' => 1, 'md' => 2])
                    ->columnSpan(1),
            ])
            ->columns([
                'default' => 1,
                'lg' => 2,
            ]);
    }

    public static function getRelations(): array
    {
        return [RelationManagers\GuestsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuestTypes::route('/'),
            'create' => Pages\CreateGuestType::route('/create'),
            'view' => Pages\ViewGuestType::route('/{record}'),
            'edit' => Pages\EditGuestType::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
