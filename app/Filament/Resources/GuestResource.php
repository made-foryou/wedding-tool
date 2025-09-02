<?php

namespace App\Filament\Resources;

use App\Domains\Guests\Enums\PresenceExportType;
use App\Domains\Guests\Models\Guest;
use App\Exports\PresenceExport;
use App\Filament\Resources\GuestResource\Pages\CreateGuest;
use App\Filament\Resources\GuestResource\Pages\EditGuest;
use App\Filament\Resources\GuestResource\Pages\ListGuests;
use App\Filament\Resources\GuestResource\Pages\ViewGuest;
use App\Filament\Resources\GuestResource\RelationManagers\AnswersRelationManager;
use App\Filament\Resources\GuestResource\RelationManagers\EventsRelationManager;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;

class GuestResource extends Resource
{
    protected static ?string $model = Guest::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'Guests';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('guest_type_id')
                ->relationship('guestType', 'name')
                ->required(),
            TextInput::make('first_name')->required()->maxLength(255),
            TextInput::make('last_name')->maxLength(255),
            TextInput::make('email')->email()->maxLength(255),
            TextInput::make('phone_number')->tel()->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('guestType.name')->sortable(),
                TextColumn::make('first_name')->searchable(),
                TextColumn::make('last_name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone_number')->searchable(),
                IconColumn::make('has_registered')->boolean(),
                IconColumn::make('email_sent')->boolean(),
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
            ->filters(self::tableFilters())
            ->recordActions([ViewAction::make(), EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Action::make('Exporteren')
                    ->schema([
                        Select::make('type')
                            ->options(PresenceExportType::options())
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $type = PresenceExportType::tryFrom($data['type']);

                        if ($type) {
                            return Excel::download(new PresenceExport($type), 'guests.xlsx');
                        }

                        return false;
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AnswersRelationManager::class,
            EventsRelationManager::class,
        ];
    }

    /**
     * @return array<int, BaseFilter>
     */
    public static function tableFilters(string $context = 'resource'): array
    {
        $filters = [];

        if ($context === 'resource') {
            $filters[] = TrashedFilter::make();
        }

        return $filters;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGuests::route('/'),
            'create' => CreateGuest::route('/create'),
            'view' => ViewGuest::route('/{record}'),
            'edit' => EditGuest::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
