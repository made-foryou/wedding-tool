import { inviteTemplates } from '@/templates/invites/templates';
import { GuestType } from '@/types/resources';
import { router } from '@inertiajs/react';

type InvitePageProps = {
    model: GuestType;
};

export default function Invite({ model }: InvitePageProps): React.JSX.Element {
    const Template = inviteTemplates.tinder;

    const acceptHandler = () => {
        router.visit('/' + model.name + '/present');
    };

    const absentHandler = () => {
        router.visit('/' + model.name + '/absent');
    };

    const bioHandler = () => {
        router.visit('/' + model.name + '/bio');
    };

    return (
        <Template
            onPresent={acceptHandler}
            onAbsent={absentHandler}
            onBio={bioHandler}
            type={model.name === 'Weekender' ? 'weekend' : 'avond'}
        />
    );
}
