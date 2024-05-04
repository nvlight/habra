<?php

namespace Feature\Api\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCommentTest extends TestCase
{
    use RefreshDatabase;

    private Comment $comment;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $post = Post::factory()->for($user, 'author')->create();

        $this->comment = Comment::factory()
            ->for($post)
            ->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_comment(): void
    {
        // sail artisan test --filter=GetCommentTest

        $response = $this->get(route('comment.show', ['comment' => $this->comment->id]));

        $response->assertOk();

        $response->assertJsonIsObject();

        $response->assertJsonStructure([
            "id",
            "text",
            "parent_id",
            "user_id",
            "post_id",
        ]);

        $response->assertJson([
            "id" => $this->comment->id,
            "text" => $this->comment->text,
            "parent_id" => $this->comment->parent_id,
            "user_id" => $this->comment->user_id,
            "post_id" => $this->comment->post_id,
        ]);
    }
}
