<?php

namespace App\Filament\Resources;

use App\Domains\Guests\Enums\PresenceExportType;
use App\Domains\Guests\Models\Guest;
use App\Domains\Guests\Models\GuestType;
use App\Domains\Presence\Models\Event;
use App\Domains\Question\Models\Question;
use App\Exports\PresenceExport;
use App\Filament\Resources\GuestResource\Pages\CreateGuest;
use App\Filament\Resources\GuestResource\Pages\EditGuest;
use App\Filament\Resources\GuestResource\Pages\ListGuests;
use App\Filament\Resources\GuestResource\Pages\ViewGuest;
use App\Filament\Resources\GuestResource\RelationManagers\AnswersRelationManager;
use App\Filament\Resources\GuestResource\RelationManagers\EventsRelationManager;
use App\Livewire\PresenceOverview;
use App\Mail\AbsentConfirmationMail;
use App\Mail\PresentConfirmationMail;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

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
            TextInput::make('phone_number')->maxLength(255),
            Toggle::make('has_registered')->default(false),
            Toggle::make('present')->default(false),
            Toggle::make('email_sent')->default(false),
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
                IconColumn::make('present')->boolean(),
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
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('mail')
                    ->label('Verstuur e-mail')
                    ->schema([
                        Checkbox::make('force')
                            ->label('Geforceerd de e-mail versturen?')
                            ->helperText('Wanneer de e-mail al is verstuurd naar deze gast dan wordt de e-mail niet verstuurd. Tenzij je dit vinkje aanvinkt. Dan wordt de e-mail altijd verstuurd.'),
                    ])
                    ->action(function (array $data, Guest $record): void {

                        if ($record->email === null) {
                            Notification::make()
                                ->title('Geen e-mailadres')
                                ->body('Er is nog geen e-mailadres bekend van deze persoon waardoor we de e-mail niet kunnen versturen.')
                                ->danger()
                                ->send();

                            return;
                        }

                        if ($record->email_sent && $data['force'] === false) {
                            Notification::make()
                                ->title('Al verstuurd')
                                ->body('Deze persoon heeft de e-mail al ontvangen en je hebt hem niet geforceerd verstuurd. Hierdoor wordt de e-mail niet verstuurd.')
                                ->info()
                                ->send();

                            return;
                        }

                        if ($record->events->isNotEmpty()) {
                            Mail::to($record->email)
                                ->send(new PresentConfirmationMail($record));
                        } else {
                            Mail::to($record->email)
                                ->send(new AbsentConfirmationMail($record));
                        }

                        $record->email_sent = true;
                        $record->save();

                        Notification::make()
                            ->title('E-mail verstuurd')
                            ->body('De e-mail is met success verstuurd aan de persoon.')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),

                    ExportBulkAction::make()
                        ->exports([
                            ExcelExport::make()
                                ->askForFilename()
                                ->withColumns(self::getExportColumns()),
                        ]),
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

    public static function getExportColumns(): array
    {
        $columns = [
            Column::make('id')->heading('Nummering'),
            Column::make('name')->heading('Naam'),
            Column::make('email')->heading('E-mailadres'),
            Column::make('phone_number')->heading('Telefoonnummer'),
            Column::make('guestType.name')->heading('Gast type'),
        ];

        $events = Event::all();

        foreach ($events as $event) {
            $columns[] = Column::make('event-'.$event->id)
                ->heading('Aanwezig '.$event->name)
                ->getStateUsing(
                    function (Guest $record) use ($event): string {
                        return $record->load('events')
                            ->events
                            ->contains('id', '=', $event->id) ? 'Ja' : 'Nee';
                    }
                );
        }

        $questions = Question::all();

        foreach ($questions as $question) {
            $columns[] = Column::make('question-'.$question->id)
                ->heading('Antwoord '.$question->label)
                ->getStateUsing(fn (Guest $record): string => $record->load('questions')->questions
                    ->filter(fn (Question $item): bool => $item->id === $question->id)
                    ->first()?->pivot->answer ?? '-'
                );
        }

        return $columns;
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

            $filters[] = SelectFilter::make('guest_type_id')
                ->options([
                    GuestType::all()->mapWithKeys(fn (GuestType $type): array => [$type->id => $type->name])->all(),
                ]);

            $filters[] = TernaryFilter::make('has_registered')
                ->label('Heeft zijn aanwezigheid zelf aangemeld?')
                ->trueLabel('Ja')
                ->falseLabel('Nee');

            $filters[] = TernaryFilter::make('present')
                ->label('Is hij/zij aanwezig?')
                ->trueLabel('Ja')
                ->falseLabel('Nee');
        }

        return $filters;
    }

    public static function getWidgets(): array
    {
        return [
            PresenceOverview::class,
        ];
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
