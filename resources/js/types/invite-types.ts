export type InviteTemplate = {
    onPresent: () => void;
    onAbsent: () => void;
    onBio: () => void;
    type: string;
};
