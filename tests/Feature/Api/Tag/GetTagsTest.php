<?php

namespace Feature\Api\Tag;

use App\Models\Company;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTagsTest extends TestCase
{
    use RefreshDatabase;

    private Collection $tags;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tags = Tag::factory(5)->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_tags(): void
    {
        // sail artisan test --filter=GetTagsTest

        $response = $this->get(route('tag.index'));

        $response->assertOk();

        $response->assertJsonIsArray();

        $response->assertJsonStructure([
            '*' => [
                "id",
                "name",
            ]
        ]);
    }
}
