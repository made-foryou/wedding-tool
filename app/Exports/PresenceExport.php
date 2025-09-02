<?php

namespace App\Exports;

use App\Domains\Guests\Enums\PresenceExportType;
use App\Domains\Guests\Models\Guest;
use App\Domains\Presence\Models\Event;
use App\Domains\Question\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

readonly class PresenceExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(
        public PresenceExportType $type,
    ) {}

    public function collection(): Collection
    {
        return Guest::query()
            ->with(['guestType', 'events', 'questions'])
            ->get();
    }

    public function map($row): array
    {
        if (! $row instanceof Guest) {
            return [];
        }

        $values = [
            $row->id,
            $row->name,
            $row->email,
            $row->phone_number,
            $row->guestType->name,
        ];

        $events = Event::all();
        $questions = Question::all();

        foreach ($events as $event) {
            if ($event->guest_type_id !== $row->guest_type_id) {
                $values[] = 'n.v.t.';

                continue;
            }

            if ($row->events->contains('id', '=', $event->id)) {
                $values[] = 'Ja';
            } else {
                $values[] = 'Nee';
            }
        }

        foreach ($questions as $question) {
            if ($question->guest_type_id !== null && $question->guest_type_id !== $row->guest_type_id) {
                $values[] = 'n.v.t.';

                continue;
            }

            $answer = $row->questions->filter(
                fn (Question $item): bool => $item->id === $question->id
            )->first();

            $values[] = $answer?->pivot->answer ?? '-';
        }

        return $values;
    }

    public function headings(): array
    {
        $events = Event::all();

        $columns = [
            'Nummering',
            'Naam',
            'E-mailadres',
            'Telefoonnummer',
            'Gast type',
        ];

        foreach ($events as $event) {
            $columns[] = 'Aanwezig '.$event->name;
        }

        $questions = Question::all();

        foreach ($questions as $question) {
            $columns[] = 'Antwoord '.$question->label;
        }

        return $columns;
    }
}
