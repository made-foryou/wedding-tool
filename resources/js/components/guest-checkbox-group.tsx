import { Guest } from '@/types/resources';
import { Checkbox } from '@heroui/react';
import React from 'react';

interface GuestCheckboxGroupProps {
    event: { id: string };
    guests: Array<Guest>;
    selected: boolean;
}

export default function GuestCheckboxGroup({
    event,
    guests,
    selected = false,
}: GuestCheckboxGroupProps): React.JSX.Element {
    const guestCheckboxes = (): React.JSX.Element[] => {
        return guests.map(
            (guest: Guest): React.JSX.Element => (
                <Checkbox
                    key={event.id + ':' + guest.id}
                    name={event.id + ':' + guest.id}
                    defaultSelected={selected}
                    value={'1'}
                >
                    {guest.name}
                </Checkbox>
            ),
        );
    };

    return <>{guestCheckboxes()}</>;
}
