export interface Resource<TModel> {
    data: TModel;
}

export interface GuestType {
    id: string;

    name: string;
    description: string;

    created_at: string;
    updated_at: string;

    guests: Array<Guest>;
    availableGuests: Array<Guest>;
    events: Array<Event>;
}

export interface Guest {
    type: GuestType;
    present: boolean;

    id: string;

    name: string;
    first_name: string;
    last_name: string | null;

    email: string;
    phone_number: string | null;

    has_registered: boolean;

    created_at: string;
    updated_at: string;
}

export interface Event {
    id: string;

    name: string;
    location: string;
    date: string;
    start: string;

    created_at: string;
    updated_at: string;
}

export interface QuestionType {
    id: string;
    name: string;
}

export interface Question {
    id: string;
    type: QuestionType;
    label: string;
    description: string;
    data: never;
    show_for_absent: boolean;
}
