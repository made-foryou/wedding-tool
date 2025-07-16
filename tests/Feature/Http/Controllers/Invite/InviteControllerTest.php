<?php

namespace Tests\Feature\Http\Controllers\Invite;

use App\Domains\Guests\Models\GuestType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Routing\Exceptions\UrlGenerationException;

class InviteControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_invite_page_needs_a_guest_type(): void
    {
        $this->expectException(UrlGenerationException::class);

        $this->get(route('invite'))->assertNotFound();
    }

    #[Test]
    public function it_can_load_with_a_guest_type(): void
    {
        $type = GuestType::factory()->create();

        $this->get(route('invite', $type))->assertOk();
    }
}
