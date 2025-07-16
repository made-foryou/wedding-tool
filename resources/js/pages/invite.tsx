import { inviteTemplates } from '@/templates/invites/templates';
import { GuestType, Resource } from '@/types/resources';
import { router } from '@inertiajs/react';

type InvitePageProps = {
    model: Resource<GuestType>;
};

export default function Invite({ model }: InvitePageProps): React.JSX.Element {
    const type: GuestType = model.data;

    const Template = inviteTemplates.tinder;

    const acceptHandler = () => {
        router.visit(type.name + '/present');
    };

    const absentHandler = () => {
        router.visit(type.name + '/absent');
    };

    const bioHandler = () => {
        router.visit(type.name + '/bio');
    };

    return <Template onPresent={acceptHandler} onAbsent={absentHandler} onBio={bioHandler} />;
}
