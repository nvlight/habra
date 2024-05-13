<?php

namespace Feature\Api\Image;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateImageTest extends TestCase
{
    use RefreshDatabase;

    private string $disk = 'public';

    private Image $image;

    private array $attributes;

    public function setUp(): void
    {
        parent::setUp();

        $this->image = Image::factory()->create();

        $this->attributes = $this->image->getAttributes();

        //$attributes['src'] = UploadedFile::fake()->image('some_2.png');

        // Путь к вашему сохраненному файлу
        $filePath = Storage::disk($this->disk)->path($this->attributes['src']);
        // Получение имени файла из пути
        $fileName = pathinfo($filePath, PATHINFO_BASENAME);
        // Определение MIME-типа файла
        $mimeType = Storage::mimeType($filePath);
        // Создание объекта UploadedFile с вашим сохраненным файлом
        $customFile = new UploadedFile($filePath, $fileName, $mimeType, null, true);
        // Использование объекта UploadedFile в вашем коде
        $this->attributes['src'] = $customFile;

        //dump($attributes['src']);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_image(): void
    {
        // sail artisan test --filter=UpdateImageTest

        $this->withoutExceptionHandling();

        $etalonImgName = $this->attributes['src'];
        $this->attributes['title'] = 'hoho ho!!';
        //dump($this->attributes['src']);

        $response = $this->put(route('image.update', $this->image), $this->attributes);
        //$response->dd();

        $response->assertOk();

        $response->assertJsonIsObject();

        $response->assertJsonStructure([
            "id",
            "title",
            "src",
        ]);

        if (Storage::disk($this->disk)->exists($etalonImgName)) {
            Storage::disk($this->disk)->delete($etalonImgName);
        }
        if (Storage::disk($this->disk)->exists($response->original['src'])) {
            Storage::disk($this->disk)->delete($response->original['src']);
        }
    }
}
