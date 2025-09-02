<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Schemas\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\GuestTypeResource\RelationManagers\GuestsRelationManager;
use App\Filament\Resources\GuestTypeResource\Pages\ListGuestTypes;
use App\Filament\Resources\GuestTypeResource\Pages\CreateGuestType;
use App\Filament\Resources\GuestTypeResource\Pages\ViewGuestType;
use App\Filament\Resources\GuestTypeResource\Pages\EditGuestType;
use App\Domains\Guests\Models\GuestType;
use App\Filament\Resources\GuestTypeResource\Pages;
use App\Filament\Resources\GuestTypeResource\RelationManagers;
use Filament\Forms;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuestTypeResource extends Resource
{
    protected static ?string $model = GuestType::class;

    protected static string | \BackedEnum | null $navigationIcon = 'carbon-data-categorical';

    protected static string | \UnitEnum | null $navigationGroup = 'Guests';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data')
                    ->schema([
                        TextInput::make('name')->required()->maxLength(255),
                        Textarea::make('description')->columnSpanFull(),
                    ])
                    ->columns(['default' => 1, 'md' => 2])
                    ->columnSpan(1),

                RichEditor::make('present_text')
                    ->hidden(fn () => ! auth()->user()->is_master_of_ceremonies),

                RichEditor::make('absent_text')
                    ->hidden(fn () => ! auth()->user()->is_master_of_ceremonies),
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
                TextColumn::make('name')->searchable(),
                TextColumn::make('created_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([TrashedFilter::make()])
            ->recordActions([ViewAction::make(), EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Guest type')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('description'),
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
        return [GuestsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGuestTypes::route('/'),
            'create' => CreateGuestType::route('/create'),
            'view' => ViewGuestType::route('/{record}'),
            'edit' => EditGuestType::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
