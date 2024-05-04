<?php

namespace Feature\Api\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCommentTest extends TestCase
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
    public function test_update_comment(): void
    {
        // sail artisan test --filter=UpdateCommentTest
        $comment = Comment::factory()
            ->for($this->post)
            ->for($this->user)
            ->make();

        // вот эта штука покажет дополнительные ошибки!
        $this->withoutExceptionHandling();

        // это выдает 422 ошибку, но непонятно где именно ошибка
        $response = $this->actingAs($this->user)
            ->json('put', route('comment.update', $this->comment), $comment->getAttributes());

        //$response->dump();
        $response->assertOk();
    }
}
