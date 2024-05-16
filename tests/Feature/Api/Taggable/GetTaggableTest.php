<?php

namespace Feature\Api\Taggable;

use App\Models\Image;
use App\Models\Taggable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetTaggableTest extends TestCase
{
    use RefreshDatabase;

    private Collection $taggables;

    public function setUp(): void
    {
        parent::setUp();

        $this->taggables = Taggable::factory(1)->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_taggable(): void
    {
        // sail artisan test --filter=GetTaggableTest

        $response = $this->get(route('taggable.show', $this->taggables[0]));

        $response->assertJsonIsObject();

        $response->assertJsonStructure([
            "id",
            "tag_id",
            "taggable_id",
            "taggable_type",
        ]);

        $response->assertOk();
    }
}
