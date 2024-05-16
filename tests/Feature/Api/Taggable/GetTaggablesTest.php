<?php

namespace Feature\Api\Taggable;

use App\Models\Image;
use App\Models\Taggable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetTaggablesTest extends TestCase
{
    use RefreshDatabase;
    private Collection $taggables;

    public function setUp(): void
    {
        parent::setUp();

        $this->taggables = Taggable::factory(3)->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_taggables(): void
    {
        // sail artisan test --filter=GetTaggablesTest

        $response = $this->get(route('taggable.index'));

        $response->assertJsonIsArray();

        $response->assertJsonStructure([
            '*' => [
                "id",
                "tag_id",
                "taggable_id",
                "taggable_type",
            ],
        ]);

        $response->assertOk();
    }
}
