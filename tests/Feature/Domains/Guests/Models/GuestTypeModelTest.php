<?php

namespace Tests\Feature\Domains\Guests\Models;

use App\Domains\Guests\Models\GuestType;
use App\Domains\Guests\Models\Guest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GuestTypeModelTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    #[Test]
    public function it_requires_a_name(): void
    {
        $type = GuestType::factory()->create();

        $this->assertNotNull($type->name);

        $this->expectException(QueryException::class);

        $type = GuestType::factory()->create([
            'name' => null,
        ]);
    }

    #[Test]
    public function it_can_have_a_description(): void
    {
        $guestType = GuestType::factory()->create([
            'description' => $this->faker->sentence,
        ]);

        $this->assertNotNull($guestType->name);
    }

    #[Test]
    public function the_name_column_is_fillable(): void
    {
        $guestType = new GuestType([
            'name' => $this->faker->word,
        ]);

        $guestType->save();

        $this->assertNotNull($guestType->name);
        $this->assertTrue($guestType->exists);
    }

    #[Test]
    public function the_description_column_is_fillable(): void
    {
        $guestType = new GuestType([
            'name' => $this->faker->word,
        ]);

        $guestType->save();

        $this->assertNotNull($guestType->name);
        $this->assertNull($guestType->description);
        $this->assertTrue($guestType->exists);

        $guestType->fill([
            'description' => $this->faker->sentence,
        ]);

        $this->assertNotNull($guestType->name);
        $this->assertNotNull($guestType->description);
        $this->assertTrue($guestType->exists);
    }

    #[Test]
    public function the_model_uses_soft_deletes(): void
    {
        $guestType = GuestType::factory()->create();

        $this->assertTrue($guestType->exists);
        $this->assertFalse($guestType->trashed());

        $guestType->delete();

        $this->assertTrue($guestType->exists);
        $this->assertTrue($guestType->trashed());
        $this->assertNotNull($guestType->deleted_at);
    }

    #[Test]
    public function the_model_can_be_restored(): void
    {
        $guestType = GuestType::factory()->create();

        $this->assertTrue($guestType->exists);
        $this->assertFalse($guestType->trashed());
        $this->assertNull($guestType->deleted_at);

        $guestType->delete();

        $this->assertTrue($guestType->exists);
        $this->assertTrue($guestType->trashed());
        $this->assertNotNull($guestType->deleted_at);

        $guestType->restore();

        $this->assertTrue($guestType->exists);
        $this->assertFalse($guestType->trashed());
        $this->assertNull($guestType->deleted_at);
    }

    #[Test]
    public function it_can_have_guests(): void
    {
        $random = $this->faker->randomDigitNotZero();

        $guestType = GuestType::factory()
            ->has(Guest::factory()->count($random))
            ->create();

        $this->assertInstanceOf(GuestType::class, $guestType);
        $this->assertInstanceOf(Collection::class, $guestType->guests);
        $this->assertEquals($random, $guestType->guests->count());
        $this->assertInstanceOf(Guest::class, $guestType->guests->first());
    }

    #[Test]
    public function name_must_be_unique(): void
    {
        $name = $this->faker->word;

        $type = GuestType::factory()->create([
            'name' => $name,
        ]);

        $this->assertEquals($name, $type->name);

        $this->expectException(UniqueConstraintViolationException::class);

        $guest2 = GuestType::factory()->create([
            'name' => $name,
        ]);
    }
}
