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
    //use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_store_image(): void
    {
        // sail artisan test --filter=StoreImageTest

        $image = Image::factory()->make();

        $this->withoutExceptionHandling();

        $attributes = $image->getAttributes();

        $disk = 'public';

        $originalImage = $image->src;

        // Путь к вашему сохраненному файлу
        $filePath = Storage::disk($disk)->path($attributes['src']);
        // Получение имени файла из пути
        $fileName = pathinfo($filePath, PATHINFO_BASENAME);
        // Определение MIME-типа файла
        $mimeType = Storage::mimeType($filePath);
        // Создание объекта UploadedFile с вашим сохраненным файлом
        $customFile = new UploadedFile($filePath, $fileName, $mimeType, null, true);
        // Использование объекта UploadedFile в вашем коде
        $attributes['src'] = $customFile;

        $response = $this->post(route('image.store'), $attributes);

        $response->assertCreated();

        $response->assertJsonIsObject();

        $response->assertJsonStructure([
            "id",
            "title",
            "src",
        ]);

        if (Storage::disk($disk)->exists($originalImage)) {
            Storage::disk($disk)->delete($originalImage);
        }
        if (Storage::disk($disk)->exists($response->original['src'])) {
            Storage::disk($disk)->delete($response->original['src']);
        }
    }
}
