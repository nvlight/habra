<?php

namespace Feature\Api\Imagable;

use App\Models\Imagable;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetImagableTest extends TestCase
{
    use RefreshDatabase;

    private string $disk = 'public';
    private Collection $imagables;

    public function setUp(): void
    {
        parent::setUp();

        $this->imagables = Imagable::factory(1)->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_imagable(): void
    {
        // sail artisan test --filter=GetImagableTest

        $response = $this->get(route('imagable.show', $this->imagables[0]));

        $response->assertJsonIsObject();

        $response->assertJsonStructure([
            "id",
            "image_id",
            "imagable_id",
            "imagable_type",
        ]);

        $response->assertOk();

        foreach($this->imagables as $im){
            $image = Image::query()->find($im->image_id);
            if ($image) {
                if (Storage::disk($this->disk)->exists($image->src)) {
                    Storage::disk($this->disk)->delete($image->src);
                }
            }
        }
    }
}
