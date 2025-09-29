<?php

namespace App\Filament\Actions;

use App\Domains\Guests\Models\Guest;
use App\Mail\CustomEmail;
use App\Models\Email;
use App\Models\Recipient;
use Filament\Actions\BulkAction;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

class SendEmailBulkAction extends BulkAction
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'send e-mail';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Verstuur e-mail');

        $this->schema([
            Select::make('email')
                ->label('E-mail')
                ->options(
                    Email::query()
                        ->get()
                        ->mapWithKeys(fn (Email $email): array => [$email->id => $email->subject])
                        ->toArray()
                )
                ->required(),
        ]);

        $this->action(function (): void {
            $this->process(static function (SendEmailBulkAction $action, Collection $records, array $data): void {
                $email = Email::findOrFail((int) $data['email']);

                $records->load('recipients');

                $records
                    ->filter(fn (Guest $guest): bool => $guest->recipients->filter(fn (Recipient $recipient): bool => $recipient->email_id === $email->id)->count() === 0)
                    ->each(function (Guest $guest) use ($email) {
                        $recipient = new Recipient;
                        $recipient->email_id = $email->id;
                        $recipient->guest_id = $guest->id;
                        $recipient->sent_at = now();
                        $recipient->save();

                        Mail::to($guest->email)
                            ->send(new CustomEmail($email));
                    });
            });
        });
    }
}
