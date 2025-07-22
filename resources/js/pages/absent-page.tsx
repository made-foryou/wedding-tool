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
            formData.set('guests[]', item.id);
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
                    }, 5000);
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
                                <ModalBody className="py-8">
                                    <p>
                                        Wat ontzettend leuk dat je aanwezig bent op onze bruiloft!
                                    </p>
                                    <p>
                                        Selecteer hieronder wie je bent en ga verder om nog meer
                                        mensen aan te melden en je gegevens achter te laten.
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
                                <p>
                                    Wat ontzettend leuk dat je er bij bent wanneer wij gaan trouwen!
                                </p>
                                <p>
                                    Geef hier onder je aanwezigheid op voor de verschillende dagen
                                    en/of meld nog meer mensen aan:
                                </p>
                            </CardBody>
                            <CardFooter></CardFooter>
                        </Card>
                        <EventsAvailability
                            events={guestType.events}
                            guests={guests}
                            selected={false}
                        ></EventsAvailability>
                        <div className="p-4">
                            <Button color="primary" variant="shadow" type="submit">
                                Opslaan
                            </Button>
                        </div>

                        <Button
                            className="fixed bottom-4 right-4 z-30"
                            color="success"
                            isIconOnly
                            size="lg"
                            radius="full"
                            variant="shadow"
                            onPress={drawer.onOpen}
                        >
                            <svg
                                className="size-8 fill-none stroke-current"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                            >
                                <path d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"></path>
                            </svg>
                        </Button>
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
