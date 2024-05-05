<?php

namespace Feature\Api\Image;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DestroyImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_destroy_image(): void
    {
        // sail artisan test --filter=DestroyImageTest

        $image = Image::factory()->create();

        $this->withoutExceptionHandling();

        $response = $this->get(route('image.destroy', $image));

        $response->assertOk();

        $disk = 'public';
        if (Storage::disk($disk)->exists($image->src)) {
            Storage::disk($disk)->delete($image->src);
        }
    }
}
