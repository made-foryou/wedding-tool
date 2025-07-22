<x-mail::message>
    # Gezellig!

    Hey {{ $guest->first_name }}, wat ontzettend gezellig dat je met ons ons huwelijk wilt komen vieren.

    <x-mail::button :url="$url">
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
