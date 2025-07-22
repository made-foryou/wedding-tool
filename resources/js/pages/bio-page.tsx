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
                            <ModalBody>
                                <h3>
                                    De allerlaatste, ja, echt de laatste: feestje met René van
                                    Dalen!
                                </h3>
                                <p>
                                    Woon je niet op ‘s-Gravendeel, dan kunnen we ons voorstellen dat
                                    je denkt: Wie is dat..? Woon je wel op ‘s-Gravendeel, dan kun je
                                    er eigenlijk niet omheen. Dé FeestDJ van het dorp. Zelf vinden
                                    we het echt fantastisch dat hij wil draaien op onze bruiloft.
                                    Muriël is ongeveer met zijn DJ-kunsten opgegroeid, en
                                    waarschijnlijk zijn haar dansskills hier ook op gebaseerd (die
                                    handjes, die handjes in de lucht!).
                                </p>
                                <p>
                                    Als we denken aan René dan kunnen we zoveel momenten opnoemen
                                    waar hij heeft gedraaid. Vooral voor Muriël is dit een flinke
                                    trip-down-memory-lane.
                                </p>
                                <p>
                                    Zo dacht Muriël direct aan de Pietendisco op basisschool
                                    Bouwsteen, waar je in de hal met de hele bovenbouw (of
                                    onderbouw) ging feesten ter afsluiting van het sinterklaasfeest.
                                    Echter twijfelt ze zelf wel of ze dit mee heeft gemaakt als kind
                                    of in de jaren dat ze hielp bij haar moeder bij de kleuters op
                                    vrije dagen. Het kan overigens ook nog zijn vanuit de periode
                                    dat ze zwarte piet speelde bij het Sinterklaasfeest.
                                </p>
                                <p>
                                    Ook was René als dj aanwezig op een van de eerste feesten die ze
                                    organiseerde, namelijk de afsluiting van groep 8 van haar
                                    broertje: Jasper.
                                </p>
                                <p>
                                    René was niet alleen te vinden op een feestje van Jasper, maar
                                    ook op een feestje van de ouders van Muriël: Piet & Jeanette.
                                    Muriël was ceremoniemeester toen zij hun jubileum: 25 jaar, 25
                                    weken, 25 dagen mochten vieren, was René aanwezig als dj.
                                </p>
                            </ModalBody>
                        </>
                    )}
                </ModalContent>
            </Modal>
        </>
    );
}
