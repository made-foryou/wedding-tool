import EventsAvailability from '@/components/events-availability';
import Invite from '@/pages/invite';
import { Guest, GuestType } from '@/types/resources';
import {
    addToast,
    Autocomplete,
    AutocompleteItem,
    Button,
    Card,
    CardBody,
    CardFooter,
    CardHeader,
    Drawer,
    DrawerBody,
    DrawerContent,
    DrawerFooter,
    DrawerHeader,
    Image,
    Modal,
    ModalBody,
    ModalContent,
    ModalHeader,
    useDisclosure,
} from '@heroui/react';
import { router, usePage } from '@inertiajs/react';
import React, { Key, useState } from 'react';

type AbsentPageProps = {
    guestType: GuestType;
};

type Option = {
    label: string;
    key: string;
};

function alreadySelected(found: Guest, selected: Array<Guest>): boolean {
    return selected.filter((item: Guest): boolean => item.id === found.id).length !== 0;
}

export default function AbsentPage({ guestType }: AbsentPageProps): React.JSX.Element {
    const { isOpen, onOpenChange, onClose } = useDisclosure({
        defaultOpen: true,
        onClose: () => {},
    });
    const drawer = useDisclosure();

    const [guests, setGuests] = useState<Array<Guest>>([]);

    const [selected, setSelected] = useState<Guest | null>(null);

    const selectionChangeHandler = (key: Key | null) => {
        const found: Guest | undefined = guestType.guests.find(
            (guest: Guest): boolean => guest.id === key,
        );

        if (found) {
            const clone = guests;
            clone.push(found);

            setGuests(clone);

            onClose();
        }
    };

    const onSelectSelectedHandler = (key: Key | null) => {
        const found: Guest | undefined = guestType.guests.find(
            (guest: Guest): boolean => guest.id === key,
        );

        if (found) {
            setSelected(found);
        }
    };

    const onSubmitHandler = () => {
        if (selected !== null) {
            const clone = guests;
            clone.push(selected);

            setGuests(clone);
        }
    };

    const guestOptions = (): Option[] => {
        return guestType.guests.map((item: Guest): Option => ({ label: item.name, key: item.id }));
    };

    const otherGuests = (): Option[] => {
        return guestType.guests
            .filter((item: Guest) => !alreadySelected(item, guests))
            .map((item: Guest): Option => ({ label: item.name, key: item.id }));
    };

    const props = usePage().props;

    const onSubmitFormHandler = (e: React.FormEvent<HTMLFormElement>): boolean => {
        e.preventDefault();

        const formData: FormData = new FormData(e.currentTarget);

        guests.forEach((item: Guest) => {
            formData.append('guests[]', item.id);
        });

        fetch('/api/save-presence', {
            method: 'POST',
            body: formData,
            credentials: 'include',
            headers: {
                'X-CSRF-Token': props.csrf_token,
                Accept: 'application/json',
            },
        })
            .then((response) => {
                return response.json();
            })
            .then((response) => {
                if (response.already_known) {
                    addToast({
                        title: 'Oeps, er gaat wat fout',
                        description:
                            response.already_known.length > 1
                                ? 'De aanwezigheid van ' +
                                  response.already_known.join(', ') +
                                  ' zijn al bekend. Voor hun kun je geen aanwezigheid meer invullen.'
                                : 'De aanwezigheid van ' +
                                  response.already_known.join(', ') +
                                  ' is al bekend. Voor hem/haar kun je geen aanwezigheid meer invullen.',
                        color: 'danger',
                    });
                } else {
                    addToast({
                        title: 'Bedankt!',
                        description:
                            guests.length > 1
                                ? 'Bedankt voor de aanmeldingen. We hebben ze goed ontvangen. Willen jullie nu een paar vragen beantwoorden?'
                                : 'Bedankt voor je aanmelding. We hebben hem goed ontvangen. Wil je nu even een paar vragen voor ons alvast beantwoorden?',
                        color: 'success',
                    });

                    setTimeout(() => {
                        router.visit('/' + guestType.name + '/questions');
                    }, 1000);
                }
            });

        return false;
    };

    if (guests.length === 0) {
        return (
            <>
                <Invite model={guestType} />
                <Modal isOpen={isOpen} placement="center" onOpenChange={onOpenChange}>
                    <ModalContent>
                        {() => (
                            <>
                                <ModalHeader className="flex flex-col gap-1">
                                    Aanmelding
                                </ModalHeader>
                                <ModalBody className="pb-8">
                                    <p>
                                        Hé, wat jammer dat je niet op onze bruiloft kunt zijn. Zou
                                        je aan willen geven wie je bent en of je alleen jezelf of
                                        ook anderen (kan in de vervolgstap) wilt afmelden! Zoek even
                                        jouw naam in de lijst!
                                    </p>

                                    <Autocomplete
                                        defaultItems={guestOptions()}
                                        label="Wie ben jij?"
                                        placeholder="Zoek & selecteer jezelf"
                                        onSelectionChange={selectionChangeHandler}
                                    >
                                        {(item) => (
                                            <AutocompleteItem key={item.key}>
                                                {item.label}
                                            </AutocompleteItem>
                                        )}
                                    </Autocomplete>
                                </ModalBody>
                            </>
                        )}
                    </ModalContent>
                </Modal>
            </>
        );
    } else {
        return (
            <>
                <div className="mb-4">
                    <Image
                        src={'/assets/logo.png'}
                        alt="Menno & Muriël"
                        width="45%"
                        className="mx-auto mt-8"
                        removeWrapper={true}
                    />
                </div>
                <div className="px-6">
                    <form onSubmit={onSubmitFormHandler}>
                        <Card>
                            <CardHeader>
                                <h3 className="font-written text-xl font-bold">
                                    Hallo {guests[0].name},
                                </h3>
                            </CardHeader>
                            <CardBody>
                                <p className="mb-4">
                                    Wat jammer dat je niet aanwezig bent op onze bruiloft! We hebben
                                    de checkboxes uitgezet, en gaan er vanuit dat je bij
                                    onderstaande momenten dus niet aanwezig bent.
                                </p>
                                <p>
                                    Klopt dat niet helemaal? Of heb je per ongeluk naar links
                                    geswipet? Geen zorgen! Dan kun je hier de checkboxes van de
                                    momenten dat je wel aanwezig bent, aanvinken. Zo kom je gewoon
                                    weer in het aanmeldproces terecht!
                                </p>
                            </CardBody>
                            <CardFooter></CardFooter>
                        </Card>
                        <EventsAvailability
                            events={guestType.events}
                            guests={guests}
                            selected={false}
                        ></EventsAvailability>
                        <div className="space-y-4 p-4">
                            <Button
                                color="success"
                                fullWidth={true}
                                variant="shadow"
                                onPress={drawer.onOpen}
                            >
                                Nog een gast aanmelden
                            </Button>

                            <Button color="primary" fullWidth={true} variant="shadow" type="submit">
                                Opslaan
                            </Button>
                        </div>
                    </form>
                </div>
                <Drawer
                    backdrop="blur"
                    placement="bottom"
                    isOpen={drawer.isOpen}
                    onOpenChange={drawer.onOpenChange}
                >
                    <DrawerContent>
                        {(onClose) => (
                            <>
                                <DrawerHeader className="flex flex-col gap-1">
                                    Nieuw persoon aanmelden
                                </DrawerHeader>
                                <DrawerBody>
                                    <Autocomplete
                                        defaultItems={otherGuests()}
                                        label="Wie wil je aanmelden"
                                        placeholder="Zoek & selecteer"
                                        onSelectionChange={onSelectSelectedHandler}
                                    >
                                        {(item) => (
                                            <AutocompleteItem key={item.key}>
                                                {item.label}
                                            </AutocompleteItem>
                                        )}
                                    </Autocomplete>
                                </DrawerBody>
                                <DrawerFooter>
                                    <Button color="danger" variant="light" onPress={onClose}>
                                        Annuleren
                                    </Button>
                                    <Button
                                        color="primary"
                                        onPress={() => {
                                            onSubmitHandler();
                                            onClose();
                                        }}
                                    >
                                        Aanmelden
                                    </Button>
                                </DrawerFooter>
                            </>
                        )}
                    </DrawerContent>
                </Drawer>
            </>
        );
    }
}
