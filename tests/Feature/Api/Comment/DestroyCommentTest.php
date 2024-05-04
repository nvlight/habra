<?php

namespace Feature\Api\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyCommentTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Post $post;
    private Comment $comment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->post = Post::factory()->for($this->user, 'author')->create();
        $this->comment = Comment::factory()->for($this->post, 'post')->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_destroy_comment(): void
    {
        // sail artisan test --filter=DestroyCommentTest

        $this->withoutExceptionHandling();

        $response = $this
            ->actingAs($this->user)
            ->delete(route('comment.destroy', $this->comment));

        $response->assertOk();
    }
}
