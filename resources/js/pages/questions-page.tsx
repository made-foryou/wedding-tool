import { Event, Guest, Question } from '@/types/resources';
import {
    addToast,
    Button,
    Card,
    CardBody,
    CardHeader,
    Checkbox,
    CheckboxGroup,
    Image,
    Input,
    Radio,
    RadioGroup,
    Select,
    SelectItem,
    Textarea,
} from '@heroui/react';
import { usePage } from '@inertiajs/react';
import React from 'react';
import Element = React.JSX.Element;

type QuestionsPageProps = {
    questions: Array<Question>;
    events: Array<Event>;
    guests: Array<Guest>;
};

export default function QuestionsPage({
    questions,
    guests,
}: QuestionsPageProps): React.JSX.Element {
    const props = usePage().props;

    const askForEmail = (guest: Guest) => {
        if (!guest.email) {
            return <Input name={guest.id + ':email'} label={'E-mailadres'} required />;
        }
    };

    const onSubmitHandler = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const formData: FormData = new FormData(event.currentTarget);

        fetch('/api/save-answers', {
            method: 'POST',
            body: formData,
            credentials: 'include',
            headers: {
                'X-CSRF-Token': props.csrf_token,
                Accept: 'application/json',
            },
        }).then((response) => {
            if (response.ok) {
                addToast({
                    title: 'Succes!',
                    description:
                        guests.length > 1
                            ? 'Bedankt voor jullie antwoorden. We hebben ze met succes ontvangen en jullie zijn succesvol aangemeld.'
                            : 'Bedankt voor je antwoorden. We hebben ze met succes ontvangen en je bent succesvol aangemeld.',
                    color: 'success',
                });

                setTimeout(() => {
                    console.log('REDIRECT TO SUCCESS PAGE');
                }, 5000);
            }
        });

        return false;
    };

    return (
        <>
            <div className="mb-4">
                ;{' '}
                <Image
                    src={'/assets/logo.png'}
                    alt="Menno & Muriël"
                    width="45%"
                    className="mx-auto mt-8"
                    removeWrapper={true}
                />
            </div>
            <div className="p-4">
                <div className="mb-6">
                    <h3 className="font-bold">Beste {guests[0].name},</h3>
                    <p>
                        Wil je nu hieronder een aantal vragen voor{' '}
                        {guests.length === 1 ? 'jou' : 'jullie'} beantwoorden?
                    </p>
                </div>
                <form onSubmit={onSubmitHandler}>
                    <div className="mb-4 mt-4 space-y-4">
                        {guests.map(
                            (guest): Element => (
                                <Card key={guest.id}>
                                    <CardHeader>
                                        <h3 className="font-bold">{guest.name}</h3>
                                    </CardHeader>
                                    <CardBody className="space-y-4 pb-6">
                                        {askForEmail(guest)}

                                        {questions.map((question) => {
                                            if (!guest.present && !question.show_for_absent) {
                                                return;
                                            }

                                            if (question.type.name === 'Open vraag') {
                                                return (
                                                    <Input
                                                        key={guest.id + ':' + question.id}
                                                        name={guest.id + ':' + question.id}
                                                        label={question.label}
                                                        description={question.description}
                                                    />
                                                );
                                            }

                                            if (question.type.name === 'Open vraag (groot)') {
                                                return (
                                                    <Textarea
                                                        key={guest.id + ':' + question.id}
                                                        name={guest.id + ':' + question.id}
                                                        label={question.label}
                                                        description={question.description}
                                                    ></Textarea>
                                                );
                                            }

                                            if (question.type.name === 'Optie selecteren') {
                                                return (
                                                    <Select
                                                        key={guest.id + ':' + question.id}
                                                        name={guest.id + ':' + question.id}
                                                        label={question.label}
                                                        description={question.description}
                                                    >
                                                        {question.data.map((item) => (
                                                            <SelectItem key={item.value}>
                                                                {item.label}
                                                            </SelectItem>
                                                        ))}
                                                    </Select>
                                                );
                                            }

                                            if (question.type.name === 'Meerkeuze') {
                                                return (
                                                    <CheckboxGroup
                                                        key={guest.id + ':' + question.id}
                                                        label={question.label}
                                                        description={question.description}
                                                    >
                                                        {question.data.map((item) => (
                                                            <Checkbox
                                                                name={
                                                                    guest.id +
                                                                    ':' +
                                                                    question.id +
                                                                    '[]'
                                                                }
                                                                key={item.value}
                                                                value={item.value}
                                                            >
                                                                {item.label}
                                                            </Checkbox>
                                                        ))}
                                                    </CheckboxGroup>
                                                );
                                            }

                                            if (question.type.name === 'Ja of nee') {
                                                return (
                                                    <RadioGroup
                                                        key={guest.id + ':' + question.id}
                                                        name={guest.id + ':' + question.id}
                                                        label={question.label}
                                                        description={question.description}
                                                    >
                                                        <Radio
                                                            name={guest.id + ':' + question.id}
                                                            value="ja"
                                                        >
                                                            Ja
                                                        </Radio>
                                                        <Radio
                                                            name={guest.id + ':' + question.id}
                                                            value="nee"
                                                        >
                                                            Nee
                                                        </Radio>
                                                    </RadioGroup>
                                                );
                                            }
                                        })}
                                    </CardBody>
                                </Card>
                            ),
                        )}
                    </div>
                    <Button fullWidth={true} type="submit" color="primary">
                        Antwoorden versturen
                    </Button>
                </form>
            </div>
        </>
    );
}
