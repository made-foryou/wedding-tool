<?php

namespace App\Filament\Resources\Emails\Schemas;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('subject')
                            ->required(),

                        MarkdownEditor::make('content')
                            ->hidden(fn () => ! auth()->user()->is_master_of_ceremonies),
                    ]),
            ])
            ->columns(1);
    }
}
