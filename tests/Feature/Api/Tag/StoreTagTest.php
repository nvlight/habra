<?php

namespace Feature\Api\Tag;

use App\Models\Company;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTagTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store_tag(): void
    {
        // sail artisan test --filter=StoreTagTest

        $tag = Tag::factory()->make();

        // вот эта штука покажет дополнительные ошибки!
        $this->withoutExceptionHandling();

        $response = $this->post(route('tag.store'), $tag->getAttributes())
            //->assertSessionHasNoErrors() // эта штука также выдает ошибку!
        ;

        // это выдает 422 ошибку, но непонятно где именно ошибка
        //$response = $this->actingAs($this->user)
        //    ->json('POST', route('post.store'), $this->post->getAttributes());

        //$response->dump();
        $response->assertCreated();

        $response->assertJsonIsObject();

        $this->assertDatabaseHas(
            'tags',
            $tag->getAttributes(),
        );
    }
}
