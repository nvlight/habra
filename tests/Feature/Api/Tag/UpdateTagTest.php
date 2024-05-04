<?php

namespace Feature\Api\Tag;

use App\Models\Company;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTagTest extends TestCase
{
    use RefreshDatabase;

    private Tag $tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tag = Tag::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_update_tag(): void
    {
        // sail artisan test --filter=UpdateTagTest

        $tag = Tag::factory()->make();

        // вот эта штука покажет дополнительные ошибки!
        $this->withoutExceptionHandling();

        //$response = $this->actingAs($this->user)
        //    ->post(route('post.update', $this->post), $post->getAttributes())
        //    //->assertSessionHasNoErrors() // эта штука также выдает ошибку!
        //;

        // это выдает 422 ошибку, но непонятно где именно ошибка
        $response = $this->json('put', route('tag.update', $this->tag), $tag->getAttributes());

        //$response->dump();
        $response->assertOk();
    }
}
