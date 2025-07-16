import { InviteTemplate } from '@/types/invite-types';
import { Button, Image, Tooltip } from '@heroui/react';
import confetti from 'canvas-confetti';
import React from 'react';
import 'swiper/css';
import 'swiper/css/effect-cards';
import { EffectCards } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';

const CancelIcon = ({ ...props }): React.JSX.Element => (
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" {...props}>
        <path
            fillRule="evenodd"
            d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
            clipRule="evenodd"
        />
    </svg>
);

const SuperLikeIcon = ({ ...props }): React.JSX.Element => (
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" {...props}>
        <path
            fillRule="evenodd"
            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
            clipRule="evenodd"
        />
    </svg>
);

const LikeIcon = ({ ...props }): React.JSX.Element => (
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" {...props}>
        <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
    </svg>
);

export default function TinderTemplate({ onPresent, onAbsent }: InviteTemplate): React.JSX.Element {
    const handleConfetti = (colors: string[]) => {
        confetti({
            scalar: 2,
            spread: 180,
            particleCount: 30,
            origin: { y: -0.1 },
            startVelocity: -35,
            colors: colors,
        });
    };

    const present = () => {
        handleConfetti(['#4ade80', '#34d399', '#2dd4bf']);

        window.setTimeout(() => {
            onPresent();
        }, 1000);
    };

    const absent = () => {
        handleConfetti(['#f87171', '#fb923c', '#fbbf24']);

        window.setTimeout(() => {
            onAbsent();
        }, 1000);
    };

    const superPresent = () => {
        handleConfetti(['#22d3ee', '#0ea5e9', '#60a5fa']);

        window.setTimeout(() => {
            onPresent();
        }, 1000);
    };

    const reset = () => {};

    return (
        <>
            <Image
                src={'/assets/logo.png'}
                alt="Menno & Muriël"
                className="absolute -top-12 mx-auto z-20 aspect-3/2 object-cover scale-75"
                removeWrapper={true}
            />
            <div className="box-border h-[80vh] w-[100vw] overflow-hidden px-[6%] pt-[5vh]">
                <Swiper
                    style={{ height: '100%' }}
                    effect={'cards'}
                    grabCursor={true}
                    modules={[EffectCards]}
                    initialSlide={1}
                    onReachEnd={absent}
                    onReachBeginning={present}
                >
                    <SwiperSlide className="h-100 rounded-3xl">
                        <Image
                            src={
                                'https://images.unsplash.com/photo-1501901609772-df0848060b33?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8Y291cGxlfGVufDB8fDB8fHww'
                            }
                            height={'100%'}
                            width="100%"
                            removeWrapper={true}
                            style={{
                                objectFit: 'cover',
                            }}
                        />
                    </SwiperSlide>
                    <SwiperSlide className="h-100 rounded-3xl">
                        <Image
                            src={
                                'https://plus.unsplash.com/premium_photo-1676667573156-7d14e8b79ad3?q=80&w=5670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
                            }
                            height={'100%'}
                            width="100%"
                            removeWrapper={true}
                            style={{
                                objectFit: 'cover',
                            }}
                        />
                    </SwiperSlide>
                    <SwiperSlide className="h-100 rounded-3xl">
                        <Image
                            src={
                                'https://images.unsplash.com/photo-1519307212971-dd9561667ffb?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fFNhZCUyMGNvdXBsZXxlbnwwfHwwfHx8MA%3D%3D'
                            }
                            height={'100%'}
                            width="100%"
                            removeWrapper={true}
                            style={{
                                objectFit: 'cover',
                            }}
                        />
                    </SwiperSlide>
                </Swiper>
            </div>
            <div className="box-border h-[20vh] w-full px-16 py-10">
                <div className="flex items-center justify-between">
                    <Tooltip content="Nee, ik ben niet aanwezig">
                        <Button
                            isIconOnly
                            aria-label="dislike"
                            color="danger"
                            size="lg"
                            radius="full"
                            variant="shadow"
                            onPress={absent}
                        >
                            <CancelIcon class="size-8" />
                        </Button>
                    </Tooltip>
                    <Tooltip content="Jazeker, Natuurlijk ben ik aanwezig!">
                        <Button
                            isIconOnly
                            aria-label="dislike"
                            color="secondary"
                            radius="full"
                            variant="shadow"
                            onPress={superPresent}
                        >
                            <SuperLikeIcon class="size-6" />
                        </Button>
                    </Tooltip>
                    <Tooltip content="Ja, ik ben aanwezig">
                        <Button
                            isIconOnly
                            aria-label="dislike"
                            color="success"
                            size="lg"
                            radius="full"
                            variant="shadow"
                            onPress={present}
                        >
                            <LikeIcon class="size-8" />
                        </Button>
                    </Tooltip>
                </div>
            </div>
        </>
    );
}
