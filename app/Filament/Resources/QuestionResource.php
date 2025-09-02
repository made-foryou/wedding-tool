<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\QuestionResource\Pages\ListQuestions;
use App\Filament\Resources\QuestionResource\Pages\CreateQuestion;
use App\Filament\Resources\QuestionResource\Pages\EditQuestion;
use App\Domains\Question\Models\Question;
use App\Filament\Resources\QuestionResource\Pages;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('question_type_id')
                    ->relationship('questionType', 'name')
                    ->live()
                    ->required(),

                Select::make('guest_type_id')
                    ->relationship('guestType', 'name')
                    ->nullable(),

                Select::make('event_id')
                    ->relationship('event', 'name')
                    ->nullable(),

                TextInput::make('label')
                    ->required(),

                Textarea::make('description')
                    ->nullable(),

                TextInput::make('index')
                    ->numeric()
                    ->required(),

                Repeater::make('data')
                    ->hidden(fn (Get $get) => ! in_array($get('question_type_id'), [4, 5]))
                    ->schema([
                        TextInput::make('label')
                            ->required(),
                        TextInput::make('value')
                            ->required(),
                    ]),

                Toggle::make('is_hidden'),

                Toggle::make('show_for_absent'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => ListQuestions::route('/'),
            'create' => CreateQuestion::route('/create'),
            'edit' => EditQuestion::route('/{record}/edit'),
        ];
    }
}
