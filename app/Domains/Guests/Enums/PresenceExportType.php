<?php

namespace App\Domains\Guests\Enums;

enum PresenceExportType: string
{
    case Complete = 'complete';

    public function label(): string
    {
        return match ($this) {
            self::Complete => 'Compleet',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (PresenceExportType $type): array => [$type->value => $type->label()])
            ->all();
    }
}
