<x-mail::message>
# Lieve {{ $guest->first_name }},

Wat leuk dat je op 24 / 25 / 26 oktober 2025 erbij bent om de liefde met ons te vieren.
Wij kijken er erg naar uit.

Een aantal dingen zijn wel handig om te weten:

🎶 *Locatie: Landgoed Twistvliet @ Koningin Emmaweg 4, 4354 KC Vrouwenpolder*
Gedurende dagen zullen we niet wisselen van locatie, blijf je op locatie overnachten? Dan hoef je dus niet na te
denken over vervoer en of je wel/niet kunt drinken. Heb je nog niks gereserveerd? Er is nog één lodge
beschikbaar. Maar we kunnen niets garanderen.

In de omgeving zijn er ook verschillende hotels of b&b’s die je kunt reserveren. Dit ligt over het algemeen wel op
een stukje rijden. Dus dan is een taxi misschien wel praktisch. De locatie is overigens ruim een uur rijden
van ‘s-Gravendeel.

### Weekendplanning

🍻 *Vrijdag 24 oktober, 20:00 - 23:30*
Incheck: vanaf 15:00
*Start borrel / spelletjesavond:  20:00*
*Eindtijd: 23:30*

Aangezien je ons aardig kent, weet je ook dat we zelf enorm houden van spelletjes spelen. Daarom zullen er tijdens
de borrel bord- en kaartspelletjes liggen die je gewoon kunt pakken en spelen met een groepje. Gelijk een
leuke manier om ook andere weekendgasten te leren kennen. Heb je zelf nou een favoriet spel, dan mag je
deze natuurlijk meenemen! Voorzie hem wel even van een naam, dan kun je hem later ook nog terugvinden.
Hou je zelf helemaal niet van spelletjes, dan hoeft het natuurlijk niet!

💍 *Zaterdag 25 oktober, 11:00 - 00:30*
We hopen dat deze dag relaxed verloopt en dat het een beetje lekker weer is. De tijd tot de ceremonie mag je namelijk
zelf invullen. Binnen 15 minuten lopen ben je op het strand (route via Roompot is het snelst). Ook kun je naar
natuurgebied Oranjezon. Dit is ongeveer 5 minuten rijden van Landgoed Twistvliet. Ook als je even het dorpje
in wilt of lekker bij het huisje wilt blijven, is dat natuurlijk prima!

🥐 *Brunch: 11:00 - 13:00*
De brunch krijg je van ons, ook als je niet blijft overnachten in een van de huisjes op de locatie. Dus slaap je
thuis, in een hotel in de buurt of blijf je kamperen ook dan ben je van harte welkom. Wij zullen er zelf niet
bij zijn, aangezien we elkaar pas zien bij de ceremonie.

👰‍♀️ *Ceremonie: 13:30*
🥂 *Proosten & borrel*
🍟 *Diner: 17:00*
🪩 *Inloop feest: 19:30*
💃 *Start feest: 20:00*
👋 *Einde feest: 00:30*

☕ *Zondag 26 oktober, 10:00*
Waar je ook overnacht, we zouden het leuk vinden als je blijft ontbijten om na te kletsen over de dagen. Ook dit
ontbijt krijg je van ons. Deze mogelijkheid bieden we ook aan alle avondgasten op eigen kosten. Een after-party
met koffie en een (kater)ontbijt dus!

Graag voorafgaand aan het ontbijt al uitchecken als je overnacht bij Twistvliet.

🎤 *Feeling creative?*
Heb je nu een creatief idee, wil je een speech geven of wil je een stukje doen? Dat vinden we hartstikke leuk!
Afhankelijk van de hoeveelheid is hier de mogelijkheid voor op vrijdagavond of tijdens de borrel. Geef het
even op tijd door aan onze ceremoniemeesters, dan zorgen zij dat het gepland wordt en al het benodigde
digitale materiaal aanwezig is.

👔 *Kleren maken de man (of vrouw)*
We zouden het leuk vinden als iedereen een beetje zijn/haar best doet om zich feestelijk te kleden. Voor de
vrijdagavond is het dus vooral: feestelijk, maar maak het niet te ingewikkeld; kies iets uit je kast waar
je je mooi in voelt en wat er feestelijk uitziet.

Voor de zaterdag houden we als thema: ✨Dress to Impress✨. Of te wel: laat de spijkerbroeken, sweaters, t-shirts etc.
achterwege en kleed je echt alsof je indruk wilt maken op iemand. Maar, laat hierbij wel de witte jurken in de kast
hangen.

📸 *Om nooit meer te vergeten!*
Heb je het nu zo naar je zin en wil je het weekend voor altijd vastleggen? Vanaf vrijdag avond tot het feest op gang
is op zaterdag, zijn er een professionele fotograaf en videograaf aanwezig. Daarna zullen er op het feest ook
genoeg mogelijkheden zijn om je aanwezigheid vast te leggen. Dus daarom willen we vragen je telefoon in je
(jas)zak, tas of huisje te houden. In ieder geval op de grotere momenten als de borrel op vrijdag, de
ceremonie, het diner en het feest en echt te genieten van het feestje met z’n allen!

🤷🏼‍♀️ *Vragen, opmerkingen, aanvullingen of wijzigingen?*
Mochten er nou op- of aanvullingen zijn in de vorm van een allergie of wijziging in aanwezigheid op een dag(deel)?
Dan zou het fijn zijn als jullie dit voor zondag 21 september aan ons door kunnen geven. Dat kan door deze
e-mail te beantwoorden, via de button hieronder , of via onze ceremoniemeesters.

<x-mail::button :url="{{ route('invite', ['guestType' => $guest->guestType]) }}">
Aanmelding aanpassen
</x-mail::button>

Wij hebben er onwijs veel zin in, hopelijk wordt het een weekend om nooit meer te vergeten!


@if ($guest->guestType->present_text)

## Hieronder volgt een bericht van de ceremoniemeesters

<x-mail::panel>
{!! str_replace('{name}', $guest->first_name, $guest->guestType->present_text) !!}
</x-mail::panel>

@endif

Liefs,<br />
Menno & Muriël

*Cadeautip:* ✉️

*Ceremoniemeesters:*
Romy van Dillen: 06 51 59 88 60
Quinten Bakker: 06 15 12 07 93
</x-mail::message>
