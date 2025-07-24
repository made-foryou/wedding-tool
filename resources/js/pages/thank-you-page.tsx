import { Image } from "@heroui/react";
import React from "react";

export default function ThankYouPage(): React.JSX.Element {
    return (
        <>
            <div className="mb-4">
                <Image
                    src={'/assets/logo.png'}
                    alt="Menno & Muriël"
                    width="45%"
                    className="mx-auto mt-8"
                    removeWrapper={true}
                />
            </div>
            <div>
                <h2 className="font-xl font-bold mb-4">Bedankt voor je aanmelding</h2>
                <p className="mb-4">
                    We hebben alles goed ontvangen. Alle personen die je hebt aangemeld en/of afgemeld
                    hebben een e-mail ontvangen met daarin meer informatie.
                </p>
                <p>
                    Liefs,<br />
                    Menno & Muriël
                </p>
            </div>
        </>
    );
}
