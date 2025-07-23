import { GuestType } from '@/types/resources';
import { Image, Modal, ModalBody, ModalContent, ModalHeader, useDisclosure } from '@heroui/react';
import { router } from '@inertiajs/react';
import React from 'react';
import Invite from './invite';

type BioPageProps = {
    guestType: GuestType;
};

export default function BioPage({ guestType }: BioPageProps): React.JSX.Element {
    const { isOpen, onClose } = useDisclosure({ isOpen: true });

    const onOpenChangeHandler = (state: boolean) => {
        if (!state) {
            onClose();

            router.visit('/' + guestType.name);
        }
    };

    const bioContent = () => {
        if (guestType.name === 'Weekender') {
            return (
                <>
                    <p>
                        Wie had ooit gedacht dat een swipe naar rechts op Tinder, gevolgd door een
                        noodtempo in ontwikkeling van daten, ouders eerder voorstellen dan vrienden
                        en alleen maar kunnen wandelen, spelletjes spelen en avondklokken omzeilen,
                        ons hier zou brengen.. Je zou het kunnen zien als een flink uit de hand
                        gelopen knuffelcontact in Coronatijd..
                    </p>
                    <p>
                        Maar ja, alleen samen krijg je een hypotheek..
                        <br />
                        <i className="text-sm">
                            (nee, we trouwen niet voor het huis, maar het was toen een populaire
                            Tinder-bio)
                        </i>
                    </p>
                    <p>
                        Nu zijn we hier niet meer voor de spelletjes (alleen bordspelletjes) en
                        willen we jou uitnodigen voor onze bruiloft op 24, 25 en 26 oktober 2025!
                    </p>
                    <p>
                        🍻 <strong>Vrijdag 24 oktober, 20:00 - 23:30</strong>
                        <br />
                        Incheck: vanaf 15:00
                        <br />
                        Start borrel / spelletjesavond: 20:00
                        <br />
                        Eindtijd: 23:30
                        <br />
                    </p>
                    <p>
                        💍<strong>Zaterdag 25 oktober, 11:00 - 00:30</strong>
                        <br />
                        🥐 Brunch: 11:00 - 13:00
                        <br />
                        👰‍♀️Ceremonie: 13:30
                        <br />
                        🥂Proosten & borrel
                        <br />
                        🍟Diner: 17:00
                        <br />
                        🪩Inloop feest: 19:30
                        <br />
                        💃Start feest: 20:00
                        <br />
                        👋Einde feest: 00:30
                    </p>
                    <p>
                        ☕ <strong>Zondag 26 oktober, 10:00 - je klaar bent met ontbijten</strong>
                    </p>
                    <p>
                        ✨ Dresscode vrijdag: Feestelijk
                        <br />✨ <strong>Dresscode zaterdag: Dress to impress</strong>
                    </p>
                    <p>
                        Meer uitleg nodig? Swipe naar rechts of geef die (gratis) superlike, vul het
                        formulier in en check je mail!
                    </p>
                </>
            );
        }

        return (
            <>
                <p>
                    Wie had ooit gedacht dat een swipeje naar rechts, een ‘zo, dus jij zit in de
                    online marketing, volgens mij ben jij ook goed in de marketing voor jezelf’ ..
                    Gevolgd door een lichte cringe, wat paniek om de snelheid en vervolgens een
                    discussie over een spelregel, ons hier zou brengen. Inmiddels zijn we de
                    one-night-stand fase redelijk voorbij.
                </p>
                <p>
                    Want ja, alleen samen kregen we die hypotheek.. 😜
                    <br />
                    <i className="text-sm">
                        (nee, we trouwen niet voor het huis, maar het was toen een populaire
                        Tinder-bio)
                    </i>
                </p>
                <p>
                    Deze match was voorbestemd voor meer, dus we gaan trouwen.
                    <br />
                    Nu is het tijd dat jij ook naar rechts swipet en ‘ja’ zegt tegen een feestje!
                </p>
                <p>
                    Een superlike mag, niks moet waar we hopen zeker op jouw aanwezigheid op:
                    <br />
                    📅 25 oktober 2025
                    <br />
                    🎶{' '}
                    <strong>
                        Locatie: Landgoed Twistvliet @ Koningin Emmaweg 4, 4354 KC Vrouwenpolder
                    </strong>
                    <br />
                    ✨ Dresscode: Dress to impress!✨
                    <br />
                    🪩 <strong>Inloop:</strong> 19:30
                    <br />
                    🤗 + 💃 <strong>Welkom & Openingsdans:</strong> 20:00 <br />
                    👋 Eind van het feest: 00:30
                    <br />
                    Cadeautip: ✉️
                </p>
                <p>Breng je moves, je glimlach en je beste dansschoenen.</p>
                <p>
                    En hé, wil jij ook een beschuitje met ons eten? 😏 Dat kan zondagochtend vanaf
                    10:00, aanmelden kan via het formulier.
                </p>
                <p>Meer informatie volgt na aanmelding in je mail!</p>
            </>
        );
    };

    return (
        <>
            <Invite model={guestType} />
            <Modal
                backdrop="blur"
                placement="bottom-center"
                isOpen={isOpen}
                scrollBehavior="inside"
                onOpenChange={onOpenChangeHandler}
            >
                <ModalContent>
                    {() => (
                        <>
                            <ModalHeader>
                                <Image
                                    src={'/assets/logo.png'}
                                    alt="Menno & Muriël"
                                    className="z-20 mx-auto h-auto w-full scale-75"
                                    removeWrapper={true}
                                />
                            </ModalHeader>
                            <ModalBody className="p-8">{bioContent()}</ModalBody>
                        </>
                    )}
                </ModalContent>
            </Modal>
        </>
    );
}
