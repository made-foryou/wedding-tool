<?php

namespace App\Filament\Resources;

use App\Domains\Question\Models\Question;
use App\Filament\Resources\QuestionResource\Pages;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

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

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
