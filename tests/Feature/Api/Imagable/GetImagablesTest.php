<?php

namespace Feature\Api\Imagable;

use App\Models\Imagable;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GetImagablesTest extends TestCase
{
    use RefreshDatabase;
    private Collection $imagables;
    private string $disk = 'public';

    public function setUp(): void
    {
        parent::setUp();

        $this->imagables = Imagable::factory(3)->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_imagables(): void
    {
        // sail artisan test --filter=GetImagablesTest

        $response = $this->get(route('imagable.index'));

        $response->assertJsonIsArray();

        $response->assertJsonStructure([
            '*' => [
                "id",
                "image_id",
                "imagable_id",
                "imagable_type",
            ],
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
