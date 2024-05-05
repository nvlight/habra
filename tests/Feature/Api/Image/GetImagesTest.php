<?php

namespace Feature\Api\Image;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetImagesTest extends TestCase
{
    use RefreshDatabase;
    private Collection $images;

    public function setUp(): void
    {
        parent::setUp();

        $this->images = Image::factory(3)->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_images(): void
    {
        // sail artisan test --filter=GetImagesTest

        $response = $this->get(route('image.index'));

        $response->assertJsonIsArray();

        $response->assertJsonStructure([
            '*' => [
                "id",
                "title",
                "src",
            ],
        ]);

        $response->assertOk();

        $this->images->map(function ($item){
            if (Storage::disk('public')->exists($item->src)){
                Storage::disk('public')->delete($item->src);
            }
            $item->delete();
        });

    }
}
