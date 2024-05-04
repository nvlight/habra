<?php

namespace Feature\Api\Comment;

use App\Models\Comment;
use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCommentsTest extends TestCase
{
    use RefreshDatabase;

    private Collection $comments;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $post = Post::factory()->for($user, 'author')->create();

        $this->comments = Comment::factory(15)
            ->for($post)
            ->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_comments(): void
    {
        // sail artisan test --filter=GetCommentsTest

        $response = $this->get(route('comment.index'));

        $response->assertOk();

        $response->assertJsonIsArray();

        $response->assertJsonStructure([
            '*' => [
                "id",
                "text",
                "parent_id",
                "user_id",
                "post_id",
            ]
        ]);
    }
}
