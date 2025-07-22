import { Event, Guest } from "./resources";

export type PresenceForm = {
    events: Array<PresenceEventForm>;
}

export type PresenceEventForm = {
    event: Event;
    guests: Array<PresenceEventGuestForm>;
}

export type PresenceEventGuestForm = {
    guest: Guest;
    presence: boolean;
    answers: { [key: string]: string | boolean | number };
}
