<x-mail::message>
# Wat jammer!

Hey {{ $guest->first_name }}, wat ontzettend jammer dat je er niet bij kunt zijn bij ons huwelijk.

<x-mail::button :url="'google.nl'">
    Aanmelding aanpassen
</x-mail::button>

@if ($guest->guestType->absent_text)

## Hieronder volgt een bericht van de ceremoniemeesters

<x-mail::panel>
    {!! $guest->guestType->absent_text !!}
</x-mail::panel>

@endif

Een vriendelijke groet,<br>
Menno & Muriël en de ceremoniemeesters
</x-mail::message>
