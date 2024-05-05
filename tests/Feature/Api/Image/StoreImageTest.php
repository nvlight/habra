<?php

namespace Feature\Api\Image;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_store_image(): void
    {
        // sail artisan test --filter=StoreImageTest

        $image = Image::factory()->make();

        $this->withoutExceptionHandling();

        $disk = 'public';
        $attributes = $image->getAttributes();

        //$attributes['src'] = Storage::disk($disk)->get($attributes['src']);
        $attributes['src'] = UploadedFile::fake()->image('some_1.png');

        $response = $this->post(route('image.store'), $attributes);

        //$response->dump();
        $response->assertCreated();

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
