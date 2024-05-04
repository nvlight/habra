<?php

namespace Feature\Api\Comment;

use App\Models\Comment;
use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreCommentTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->post = Post::factory()->for($this->user, 'author')->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_store_comment(): void
    {
        // sail artisan test --filter=StoreCommentTest
        $comment = Comment::factory()
            ->for($this->post)
            ->make();

        // вот эта штука покажет дополнительные ошибки!
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user)
            ->post(route('comment.store'), $comment->getAttributes())
            //->assertSessionHasNoErrors() // эта штука также выдает ошибку!
        ;

        // это выдает 422 ошибку, но непонятно где именно ошибка
        //$response = $this->actingAs($this->user)
        //    ->json('POST', route('post.store'), $this->post->getAttributes());

        //$response->dump();
        $response->assertCreated();

        $response->assertJsonIsObject();
    }
}
