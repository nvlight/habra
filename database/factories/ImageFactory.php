<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
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
        return [
            'title' => fake()->sentence,
            'src' => $this->saveImageToFile(),
        ];
    }

    // jpg, jpeg, png, bmp, gif, svg или webp
    protected array $extensions = [
        'jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'webp',
    ];

    protected function getImageExtension($ext='jpg')
    {
        return $ext;
    }

    protected function getRandomImageExtension($ext='jpg'): string
    {

        return Arr::random($this->extensions);
    }

    protected function getImagePrefix($prefix='image_'): string
    {
        return $prefix;
    }

    protected function getImageDimensions($dim='150x150'): string
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
        $imageData = file_get_contents($url); // Генерируем случайное изображение

        $fileName =  $this->getImagePrefix() . $this->getUnigueImageName() . '.' . $this->getImageExtension(); // Генерируем уникальное имя файла

        Storage::disk('public')->put($fileName, $imageData); // Сохраняем изображение в публичной директории

        return 'storage/' . $fileName; // Возвращаем путь к сохраненному файлу
    }
}
