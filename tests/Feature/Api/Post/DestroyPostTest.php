<?php

namespace Feature\Api\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyPostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->post = Post::factory()
            ->for($this->user, 'author')
            ->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_destroy_post(): void
    {
        // sail artisan test --filter=DestroyPostTest

        $this->withoutExceptionHandling();

        $response = $this
            ->actingAs($this->user)
            ->delete(route('post.destroy', $this->post));

        $response->assertOk();
    }
}
