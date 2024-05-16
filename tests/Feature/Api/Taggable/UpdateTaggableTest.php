<?php

namespace Feature\Api\Taggable;

use App\Models\Company;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateTaggableTest extends TestCase
{
//    use RefreshDatabase;
    private ?Tag $tag;
    private int $taggableId;
    private string $taggableType;
    private int $secondTaggableId;
    private string $secondTaggableType;
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

        $this->user = User::factory()->create();

        $this->post = Post::factory()
            ->for($this->user, 'author')
            ->create();

        $this->image = Image::factory()->create();

        if ($this->sel === 1) {
            $this->taggableId = $this->post->id;
            $this->taggableType = Post::class;

            $this->secondTaggableId = $this->image->id;
            $this->secondTaggableType = Image::class;
        }else{
            $this->taggableId = $this->image->id;
            $this->taggableType = Image::class;

            $this->secondTaggableId = $this->post->id;
            $this->secondTaggableType = Post::class;
        }

    }

    public function test_update_taggable(): void
    {
        // sail artisan test --filter=UpdateTaggableTest

        //$this->post->tags()->attach($this->tag->id);

        $attributes = [];
        $attributes['tag_id'] = $this->tag->id;
        $attributes['taggable_id'] = $this->taggableId;
        $attributes['taggable_type'] = $this->taggableType;

        $response = $this->post(route('taggable.store'), $attributes);

        $lastInsertId = DB::getPdo()->lastInsertId();

        $response->assertStatus(200);

        //
        $attributes = [];
        $attributes['tag_id'] = $this->tag->id;
        $attributes['taggable_id'] = $this->secondTaggableId;
        $attributes['taggable_type'] = $this->secondTaggableType;

        $secondResponse = $this->put(route('taggable.update', $lastInsertId), $attributes);

        $secondResponse->assertStatus(200);

        if (Storage::disk($this->disk)->exists($this->image->src)) {
            Storage::disk($this->disk)->delete($this->image->src);
        }
    }
}
