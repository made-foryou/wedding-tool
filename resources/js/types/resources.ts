export interface Resource<TModel> {
    data: TModel;
}

export interface GuestType {
    name: string;
    description: string;

    created_at: string;
    updated_at: string;

    guests: Resource<Array<Guest>>;
}

export interface Guest {
    type: GuestType;

    name: string;
    first_name: string;
    last_name: string | null;

    email: string;
    phone_number: string | null;

    created_at: string;
    updated_at: string;
}
