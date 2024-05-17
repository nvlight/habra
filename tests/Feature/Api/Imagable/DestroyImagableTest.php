<?php

namespace Feature\Api\Imagable;

use App\Models\Imagable;
use App\Models\Image;
use App\Models\Taggable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DestroyImagableTest extends TestCase
{
    use RefreshDatabase;

    private Collection $imagables;
    private string $disk = 'public';

    public function setUp(): void
    {
        parent::setUp();

        $this->imagables = Imagable::factory(1)->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_delete_imagable(): void
    {
        // sail artisan test --filter=DestroyImagableTest

        $response = $this->delete(route('imagable.show', $this->imagables[0]));

        $response->assertOk();

        $image = Image::query()->find($this->imagables[0]->image_id);
        if ($image) {
            if (Storage::disk($this->disk)->exists($image->src)) {
                Storage::disk($this->disk)->delete($image->src);
            }
        }
    }
}
