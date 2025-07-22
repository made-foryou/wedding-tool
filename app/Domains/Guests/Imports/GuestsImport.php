<?php

namespace App\Domains\Guests\Imports;

use App\Domains\Guests\Models\Guest;
use App\Domains\Guests\Models\GuestType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuestsImport implements ToModel, WithHeadingRow
{
    /**
     * @return Model|null
     */
    public function model(array $row): Model|Guest|null
    {
        return new Guest([
            'uuid' => Str::uuid(),
            'guest_type_id' => $this->getGuestTypeId($row['type_gast'] ?? null),
            'first_name' => str_contains($row['gast_naam'], ' ') ? explode(' ', $row['gast_naam'])[0] : $row['gast_naam'],
            'last_name' => str_contains($row['gast_naam'], ' ') ? trim(str_replace(explode(' ', $row['gast_naam'] ?? '')[0], '', $row['gast_naam'] ?? '')) : null,
            'email' => $row['email'] ?? null,
            'phone_number' => $row['telefoonnummer'] ?? null,
        ]);
    }

    protected function getGuestTypeId(?string $value = null): int
    {
        return match ($value) {
            'Weekend' => GuestType::query()->where('name', 'Weekender')->firstOrFail()->id,
            default => GuestType::query()->where('name', 'Avond')->firstOrFail()->id,
        };
    }
}
