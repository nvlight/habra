<?php

namespace Feature\Api\Image;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetImageTest extends TestCase
{
    use RefreshDatabase;

    private Image $image;

    public function setUp(): void
    {
        parent::setUp();

        $this->image = Image::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_images(): void
    {
        // sail artisan test --filter=GetImageTest

        $response = $this->get(route('image.show', $this->image));

        $response->assertJsonIsObject();

        $response->assertJsonStructure([
            "id",
            "title",
            "src",
        ]);

        $response->assertJson([
            "id" => $this->image->id,
            "title" => $this->image->title,
            "src" => $this->image->src,
        ]);

        $response->assertOk();

        if (Storage::disk('public')->exists($this->image->src)) {
            Storage::disk('public')->delete($this->image->src);
        }

    }
}
