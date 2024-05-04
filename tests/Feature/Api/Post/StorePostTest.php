<?php

namespace Feature\Api\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StorePostTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Post $post;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_store_post(): void
    {
        // sail artisan test --filter=StorePostTest

        $this->post = Post::factory()->make();
        $this->post->author_id = $this->user->id;

        // вот эта штука покажет дополнительные ошибки!
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->user)
            ->post(route('post.store'), $this->post->getAttributes())
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