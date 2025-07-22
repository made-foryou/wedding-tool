<x-mail::message>
Lieve {{ $guest->first_name }},

Wat leuk dat je op 25 oktober 2025 erbij bent om de liefde met ons te vieren.<br>
Wij kijken er erg naar uit! Een aantal dingen zijn wel handig om te weten:

🎶Locatie: Landgoed Twistvliet @ Koningin Emmaweg 4, 4354 KC Vrouwenpolder<br>
✨Dresscode: Dress to impress!✨<br>
🪩 Inloop: 19:30<br>
🤗 + 💃 Welkom & Openingsdans: 20:00<br>
👋 Eind van het feest: 00:30<br>
**Cadeautip:** ✉️

👔 **Kleren maken de man (of vrouw)**
Voor de zaterdag houden we als thema: ✨Dress to Impress✨. Of te wel: laat de spijkerbroeken, sweaters, t-shirts etc.
achterwege en kleed je echt alsof je indruk wilt maken op iemand. Maar, laat hierbij wel de witte jurken in de kast
hangen.

📸 **Om nooit meer te vergeten!**
Heb je het nu zo naar je zin en wil je de avond voor altijd vastleggen? Tot het feest op gang is, is er een
professionele fotograaf en videograaf aanwezig. Daarna zullen er op het feest ook genoeg mogelijkheden
zijn om je aanwezigheid vast te leggen, probeer dus daarom je telefoon in je (jas)zak of tas te
houden en echt te genieten van het feestje met z’n allen!

Deze avond hopen we vooral gezellig met z’n allen te kunnen dansen en feesten, hierdoor is er geen ruimte voor een
stukje of een speech.

Blijf je slapen in de omgeving? Dan is het **ontbijt zondagochtend om 10:00**.<br>
Het ontbijt bij ons is op eigen kosten, deze staan ook vermeld in de uitnodiging en kunnen op locatie worden voldaan.

Vind je het leuk om te blijven overnachten in de omgeving en heb je nog niks geboekt? Deze tips hebben wij nog qua
locaties:

**Te boeken via Welcome.In:**
- Lepelstraat 18 A –> 8 personen
- De Schorre –> 18 personen –> 800 meter

**Andere accommodaties in de buurt:**
- Stee aan Zee –> 4,5 kilometer
- Hoeve plantlust –> groeps accomodatie 20 personen –> 2 kilometer
- Rustenpolder –> 18 personen –> 500 meter
- Hotel de boekanier (in centrum van het dorp op loopafstand)
- Hof Christina hoevehotel (op fietsafstand)
- Duinhotel Breezand (op fietsafstand)
- Hofstede Elzenoord (de buren van twistvliet, op loopafstand)
- Strandhotel Duinoord (op fietsafstand)
- Nachtje in de kerk Vrouwenpolder (loopafstand)
- Verder zijn er in Serooskerke (4,5 km fietsafstand) en in Oostkapelle (6,5 km fietsafstand) ook diverse accommodaties te vinden.

Mochten er nou op- of aanvullingen zijn in de vorm van een allergie of wijziging in aanwezigheid? Voor zowel het feest
als het ontbijt, dan zou het fijn zijn als jullie dit voor zondag 21 september aan ons door kunnen geven. Dat kan
door deze e-mail te beantwoorden, via de button hieronder, of via onze ceremoniemeesters.

<x-mail::button :url="route('invite', ['guestType' => $guest->guestType])">
Aanmelding aanpassen
</x-mail::button>

We kijken ernaar uit om samen de liefde te vieren! ❤️

@if ($guest->guestType->present_text)

## Hieronder volgt een bericht van de ceremoniemeesters

<x-mail::panel>
{!! str_replace('{name}', $guest->first_name, $guest->guestType->present_text) !!}
</x-mail::panel>

@endif

Liefs<br>
Menno & Muriël

**Ceremoniemeesters:**
Romy van Dillen: 06 51 59 88 60
Quinten Bakker: 06 15 12 07 93

</x-mail::message>
