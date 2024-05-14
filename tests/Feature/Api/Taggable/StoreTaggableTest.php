<?php

namespace Feature\Api\Taggable;

use App\Models\Company;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTaggableTest extends TestCase
{
//    use RefreshDatabase;
    private ?Tag $tag;
    private ?Post $post;
    private ?User $user;
    private ?Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        //$this->company = Company::factory()->create();
        $this->tag = Tag::factory()->create();

        $this->post = Post::factory()
            ->for($this->user, 'author')
            //->for($this->company)
            ->create();
    }

    public function test_store_taggable(): void
    {
        // sail artisan test --filter=StoreTaggableTest
        $this->post->tags()->attach($this->tag->id);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
