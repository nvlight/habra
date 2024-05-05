<?php

namespace Feature\Api\Image;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateImageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_update_image(): void
    {
        // sail artisan test --filter=UpdateImageTest

        $image = Image::factory()->create();

        $this->withoutExceptionHandling();

        $disk = 'public';
        $attributes = $image->getAttributes();
        $attributes['title'] = 'wow, thats huge!';

        //$attributes['src'] = Storage::disk($disk)->get($attributes['src']);
        $attributes['src'] = UploadedFile::fake()->image('some_2.png');

        $response = $this->put(route('image.update', $image), $attributes);

        //$response->dump();
        $response->assertOk();

        $response->assertJsonIsObject();

        $response->assertJsonStructure([
            "id",
            "title",
            "src",
        ]);

//        if (Storage::disk($disk)->exists($attributes['src'])) {
//            Storage::disk($disk)->delete($attributes['src']);
//        }
    }
}
