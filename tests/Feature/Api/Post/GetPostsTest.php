<?php

namespace Tests\Feature\Api\Post;

use Tests\TestCase;

class GetPostsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_posts(): void
    {
        // sail artisan route:list --path=post
        // sail artisan migrate --database=testing
        // sail artisan test --filter=test_get_posts

        $response = $this->get(route('post.index'));

        //$response->assertStatus(200);
        $response->assertOk();

        $response->assertJsonStructure([
            '*' => [
                'id', 'author_id', 'company_id', 'title', 'content', 'difficulty',
                'views', 'read_time', 'likes', 'status',
            ],
        ]);
    }
}
