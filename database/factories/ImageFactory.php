<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdImg = $this->img_create();
        Log::info($createdImg);

        return [
            'title' => fake()->sentence,
            //'src' => $this->saveImageToFile(),
            'src' => $createdImg,
        ];
    }

    // jpg, jpeg, png, bmp, gif, svg или webp
    protected array $extensions = [
        'jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp',
    ];

    protected function getImageExtension($ext = 'jpg')
    {
        return $ext;
    }

    protected function getRandomImageExtension($ext = 'jpg'): string
    {

        return Arr::random($this->extensions);
    }

    protected function getImagePathPrefix($prefix = 'images'): string
    {
        return $prefix;
    }

    protected function getImagePrefix($prefix = 'image_'): string
    {
        return $prefix;
    }


    protected function getImageDimensions($dim = '150x150'): string
    {
        return $dim;
    }

    protected function getUnigueImageName(): string
    {
        return uniqid();
    }

    private function saveImageToFile(): string
    {
        $url = 'https://via.placeholder.com/' . $this->getImageDimensions();

        // Генерируем случайное изображение
        $imageData = file_get_contents($url);

        // Генерируем уникальное имя файла
        $fileName = $this->getImagePathPrefix() . '/'
            . $this->getImagePrefix()
            . $this->getUnigueImageName() . '.'
            . $this->getImageExtension();

        Storage::disk('public')->put($fileName, $imageData);

        return $fileName;
    }

    function img_create($path='images', $extension='png', $width=300, $height=200)
    {
        $imageRandomName = "{$path}/" .  time() . '-' . Str::random(11) . '.' . $extension;
        $imageFullName = "app/public/" . $imageRandomName;
        // Определяем путь для сохранения изображения
        $filePath = storage_path($imageFullName);

        // Создаем новое изображение
        $image = imagecreatetruecolor($width, $height);

        // Сохраняем изображение в указанном расширении и пути
        switch ($extension) {
            case 'png':
                imagepng($image, $filePath);
                break;
            case 'jpeg':
            case 'jpg':
                imagejpeg($image, $filePath);
                break;
            case 'gif':
                imagegif($image, $filePath);
                break;
            // Другие форматы изображений
        }

        // Освобождаем память, уничтожая изображение
        imagedestroy($image);

        return $imageRandomName; // Возвращаем путь к сохраненному изображению
    }
}
