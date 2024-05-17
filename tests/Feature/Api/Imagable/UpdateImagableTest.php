<?php

namespace Feature\Api\Imagable;

use App\Models\Company;
use App\Models\Imagable;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateImagableTest extends TestCase
{
    use RefreshDatabase;

    private ?Imagable $imagable;
    private ?Post $post;
    private string $disk = 'public';

    protected function setUp(): void
    {
        parent::setUp();

        $this->imagable = Imagable::factory()->create();

        $this->user = User::factory()->create();
        $this->post = Post::factory()
            ->for($this->user, 'author')
            ->create();
    }

    public function test_update_imagable(): void
    {
        // sail artisan test --filter=UpdateImagableTest

        $this->withoutExceptionHandling();

        $attributes = [];
        $attributes['image_id'] = $this->imagable->image_id;
        $attributes['imagable_id'] = $this->post->id;
        $attributes['imagable_type'] = $this->imagable->imagable_type;

        $response = $this->put(route('imagable.update', $this->imagable->id), $attributes);

        $response->assertStatus(200);

        $image = Image::query()->find($this->imagable->image_id);
        if ($image) {
            if (Storage::disk($this->disk)->exists($image->src)) {
                Storage::disk($this->disk)->delete($image->src);
            }
        }
    }
}
