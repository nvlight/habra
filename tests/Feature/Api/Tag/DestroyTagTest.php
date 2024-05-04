<?php

namespace Feature\Api\Tag;

use App\Models\Company;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyTagTest extends TestCase
{
    use RefreshDatabase;

    private Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tag = Tag::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_destroy_tag(): void
    {
        // sail artisan test --filter=DestroyTagTest

        $this->withoutExceptionHandling();

        $response = $this->delete(route('tag.destroy', $this->tag));

        $response->assertOk();
    }
}
