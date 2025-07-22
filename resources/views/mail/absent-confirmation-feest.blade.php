<x-mail::message>
# Lieve {{ $guest->first_name }},

Wat jammer dat je er niet bij bent om samen met ons de liefde te vieren op Landgoed Twistvliet in Vrouwenpolder.

Mocht je je afgemeld hebben en toch wel aanwezig kunnen zijn? Dan kun je jouw afwezigheid wijzigen door op voor 21
september op de knop hieronder te klikken, hierdoor kom je opnieuw in het aanmeldproces en kun je jezelf op
aanwezig zetten.

<x-mail::button :url="route('invite', ['guestType' => $guest->guestType])">
Aanmelding aanpassen
</x-mail::button>

@if ($guest->guestType->absent_text)

## Hieronder volgt een bericht van de ceremoniemeesters

<x-mail::panel>
{!! str_replace('{name}', $guest->first_name, $guest->guestType->absent_text) !!}
</x-mail::panel>

@endif

Als je vragen hebt of je er niet uit komt, neem dan ook zeker contact op met onze ceremoniemeesters. Dat kan door
deze e-mail te beantwoorden of te bellen / appen.

Liefs,<br>
Menno & Muriël

**Ceremoniemeesters:**<br>
Romy van Dillen: 06 51 59 88 60<br>
Quinten Bakker: 06 15 12 07 93
</x-mail::message>
