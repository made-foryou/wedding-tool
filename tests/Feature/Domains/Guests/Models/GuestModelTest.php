<?php

namespace Tests\Feature\Domains\Guests\Models;

use App\Domains\Guests\Models\GuestType;
use App\Domains\Guests\Models\Guest;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GuestModelTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    #[Test]
    public function it_has_a_guest_type(): void
    {
        $guest = Guest::factory()
            ->for(GuestType::factory()->create())
            ->create();

        $this->assertNotNull($guest->guestType);
        $this->assertInstanceOf(GuestType::class, $guest->guestType);
    }

    #[Test]
    public function it_requires_a_first_name(): void
    {
        $type = GuestType::factory()->create();

        $guest = Guest::factory()->for($type)->create();

        $this->assertNotNull($guest->first_name);

        $this->expectException(QueryException::class);

        $type->guests()->create([
            'first_name' => null,
            'email' => $this->faker->unique()->email,
        ]);
    }

    #[Test]
    public function it_requires_an_email(): void
    {
        $type = GuestType::factory()->create();

        $guest = Guest::factory()->for($type)->create();

        $this->assertNotNull($guest->email);

        $this->expectException(QueryException::class);

        $type->guests()->create([
            'first_name' => $this->faker->firstName,
            'email' => null,
        ]);
    }

    #[Test]
    public function it_can_have_a_last_name(): void
    {
        $guest = Guest::factory()
            ->for(GuestType::factory()->create())
            ->create([
                'last_name' => $this->faker->lastName,
            ]);

        $this->assertNotNull($guest->last_name);
    }

    #[Test]
    public function it_can_have_a_phone_number(): void
    {
        $guest = Guest::factory()
            ->for(GuestType::factory()->create())
            ->create([
                'phone_number' => $this->faker->phoneNumber,
            ]);

        $this->assertNotNull($guest->phone_number);
    }

    #[Test]
    public function email_must_be_unique(): void
    {
        $email = $this->faker->email;

        $guest = Guest::factory()
            ->for(GuestType::factory()->create())
            ->create([
                'email' => $email,
            ]);

        $this->assertEquals($email, $guest->email);

        $this->expectException(UniqueConstraintViolationException::class);

        $guest2 = Guest::factory()
            ->for(GuestType::factory()->create())
            ->create([
                'email' => $email,
            ]);
    }

    #[Test]
    public function the_first_name_column_is_fillable(): void
    {
        $guest = Guest::factory()
            ->for(GuestType::factory()->create())
            ->create();

        $this->assertNotNull($guest->first_name);
        $this->assertTrue($guest->exists);

        $guest->fill([
            'first_name' => $this->faker->firstName,
        ]);

        $this->assertNotNull($guest->first_name);
        $this->assertTrue($guest->exists);
    }

    #[Test]
    public function the_last_name_column_is_fillable(): void
    {
        $guest = Guest::factory()
            ->for(GuestType::factory()->create())
            ->create();

        $this->assertNull($guest->last_name);
        $this->assertTrue($guest->exists);

        $guest->fill([
            'last_name' => $this->faker->lastName,
        ]);

        $this->assertNotNull($guest->last_name);
        $this->assertTrue($guest->exists);
    }

    #[Test]
    public function the_email_column_is_fillable(): void
    {
        $guest = Guest::factory()
            ->for(GuestType::factory()->create())
            ->create();

        $this->assertNotNull($guest->email);
        $this->assertTrue($guest->exists);

        $guest->fill([
            'email' => $this->faker->unique()->email,
        ]);

        $this->assertNotNull($guest->email);
        $this->assertTrue($guest->exists);
    }

    #[Test]
    public function the_phone_number_is_fillable(): void
    {
        $guest = Guest::factory()
            ->for(GuestType::factory()->create())
            ->create();

        $this->assertNull($guest->phone_number);
        $this->assertTrue($guest->exists);

        $guest->fill([
            'phone_number' => $this->faker->phoneNumber,
        ]);

        $this->assertNotNull($guest->phone_number);
        $this->assertTrue($guest->exists);
    }
}
