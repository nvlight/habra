<?php

namespace Feature\Api\Tag;

use App\Models\Company;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTagTest extends TestCase
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
    public function test_get_tag(): void
    {
        // sail artisan test --filter=GetTagTest

        $response = $this->get(route('tag.show', $this->tag->id));

        $response->assertOk();

        $response->assertJsonIsObject();

        $response->assertJsonStructure([
            "id",
            "name",
        ]);

        $response->assertJson([
            "id" => $this->tag->id,
            "name" => $this->tag->name,
        ]);
    }
}
