import Invite from '@/pages/invite';
import { Guest, GuestType, Resource } from '@/types/resources';
import {
    Autocomplete,
    AutocompleteItem,
    Button,
    Drawer,
    DrawerBody,
    DrawerContent,
    DrawerFooter,
    DrawerHeader,
    Modal,
    ModalBody,
    ModalContent,
    ModalHeader,
    useDisclosure,
} from '@heroui/react';
import React, { Key, useState } from 'react';

type PresentPageProps = {
    guestType: Resource<GuestType>;
};

type Option = {
    label: string;
    key: string;
};

export default function PresentPage({ guestType }: PresentPageProps): React.JSX.Element {
    const { isOpen, onOpenChange, onClose } = useDisclosure({ isOpen: true });
    const drawer = useDisclosure();

    const [current, setCurrent] = useState<Guest | null>(null);

    const [others, setOthers] = useState<Array<Guest>>([]);

    const [selected, setSelected] = useState<Guest | null>(null);

    const selectionChangeHandler = (key: Key | null) => {
        const found: Guest | undefined = guestType.data.guests.data.find(
            (guest: Guest): boolean => guest.email === key,
        );

        if (found) {
            setCurrent(found);

            onClose();
        }
    };

    const onSelectSelectedHandler = (key: Key | null) => {
        const found: Guest | undefined = guestType.data.guests.data.find(
            (guest: Guest): boolean => guest.email === key,
        );

        if (found) {
            setSelected(found);
        }
    };

    const onSubmitHandler = () => {
        if (selected !== null) {
            const clone = others;
            clone.push(selected);

            setOthers(clone);
        }
    };

    const guests = (): Option[] => {
        return guestType.data.guests.data.map(
            (item: Guest): Option => ({ label: item.name, key: item.email }),
        );
    };

    const otherGuests = (): Option[] => {
        return guestType.data.guests.data
            .filter((item: Guest) => (current ? item.email !== current.email : false))
            .map((item: Guest): Option => ({ label: item.name, key: item.email }));
    };

    const otherElements = others.map(
        (item: Guest): React.JSX.Element => (
            <div>
                <span>{item.name}</span>
            </div>
        ),
    );

    if (current === null) {
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
                                        defaultItems={guests()}
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
                <div className="px-8 py-10">
                    <div className="mb-6">
                        <h2 className="mb-4 text-2xl">Hey {current?.name ?? 'menno'},</h2>
                        <p>Wat ontzettend leuk dat je erbij bent wanneer wij gaan trouwen!</p>
                    </div>
                    <div>
                        <span>Wil je gelijk nog iemand aanmelden?</span>
                        <Button color="primary" variant="solid" onPress={drawer.onOpen}>
                            Meld nog iemand aan
                        </Button>
                    </div>
                    <div>{otherElements}</div>
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
