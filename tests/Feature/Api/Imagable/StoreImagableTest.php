<?php

namespace Feature\Api\Imagable;

use App\Models\Company;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreImagableTest extends TestCase
{
    use RefreshDatabase;

    private int $imagableId;
    private string $imagableType;
    private ?Post $post;
    private ?Image $image;
    private ?User $user;

    private string $disk = 'public';

    private int $sel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->image = Image::factory()->create();

        $this->user = User::factory()->create();
        $this->post = Post::factory()
            ->for($this->user, 'author')
            ->create();

        $this->imagableId = $this->post->id;
        $this->imagableType = Post::class;
    }

    public function test_store_imagable(): void
    {
        // sail artisan test --filter=StoreImagableTest

        $attributes = [];
        $attributes['image_id'] = $this->image->id;
        $attributes['imagable_id'] = $this->imagableId;
        $attributes['imagable_type'] = $this->imagableType;

        $response = $this->post(route('imagable.store'), $attributes);

        $response->assertStatus(200);

        if (Storage::disk($this->disk)->exists($this->image->src)) {
            Storage::disk($this->disk)->delete($this->image->src);
        }
    }
}
