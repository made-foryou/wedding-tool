import GuestCheckboxGroup from '@/components/guest-checkbox-group';
import { Guest } from '@/types/resources';
import { Card, CardBody, CardHeader } from '@heroui/react';
import React from 'react';

interface EventsAvailabilityProps {
    events: Array<any>;
    guests: Array<Guest>;
    selected: boolean;
}

export default function EventsAvailability({
    events,
    guests,
    selected,
}: EventsAvailabilityProps): React.JSX.Element {
    return (
        <>
            <div className="mt-4 space-y-4">
                {events.map(
                    (event): React.JSX.Element => (
                        <Card key={event.id}>
                            <CardHeader className="flex-col items-start justify-start">
                                <h2 className="block text-xl font-bold">{event.name}</h2>
                                <span className="block text-base italic">
                                    {new Date(event.date).toLocaleDateString()} bij {event.location}{' '}
                                    om {event.start}
                                </span>
                            </CardHeader>
                            <CardBody>
                                <GuestCheckboxGroup
                                    event={event}
                                    guests={guests}
                                    selected={selected}
                                ></GuestCheckboxGroup>
                            </CardBody>
                        </Card>
                    ),
                )}
            </div>
        </>
    );
}
