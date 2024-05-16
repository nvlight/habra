<?php

namespace Feature\Api\Taggable;

use App\Models\Company;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreTaggableTest extends TestCase
{
    use RefreshDatabase;
    private ?Tag $tag;
    private int $taggableId;
    private string $taggableType;
    private ?Post $post;
    private ?Image $image;
    private ?User $user;

    private string $disk = 'public';

    private int $sel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tag = Tag::factory()->create();

        $this->sel = random_int(1, 2);

        if ($this->sel === 1) {
            $this->user = User::factory()->create();

            $this->post = Post::factory()
                ->for($this->user, 'author')
                ->create();

            $this->taggableId = $this->post->id;
            $this->taggableType = Post::class;
        } else {
            $this->image = Image::factory()->create();

            $this->taggableId = $this->image->id;
            $this->taggableType = Image::class;
        }

    }

    public function test_store_taggable(): void
    {
        // sail artisan test --filter=StoreTaggableTest

        //$this->post->tags()->attach($this->tag->id);

        $attributes = [];
        $attributes['tag_id'] = $this->tag->id;
        $attributes['taggable_id'] = $this->taggableId;
        $attributes['taggable_type'] = $this->taggableType;

        $response = $this->post(route('taggable.store'), $attributes);

        $response->assertStatus(200);

        if ($this->sel === 2) {
            if (Storage::disk($this->disk)->exists($this->image->src)) {
                Storage::disk($this->disk)->delete($this->image->src);
            }
        }
    }
}
