<?php

namespace Feature\Api\Company;

use App\Models\Company;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCompanyTest extends TestCase
{
    use RefreshDatabase;

    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->company = Company::factory()
            ->for($this->user, 'spokesperson')
            ->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_update_company(): void
    {
        // sail artisan test --filter=UpdateCompanyTest

        $company = Company::factory()->make();

        // вот эта штука покажет дополнительные ошибки!
        $this->withoutExceptionHandling();

        //$response = $this->actingAs($this->user)
        //    ->post(route('post.update', $this->post), $post->getAttributes())
        //    //->assertSessionHasNoErrors() // эта штука также выдает ошибку!
        //;

        // это выдает 422 ошибку, но непонятно где именно ошибка
        $response = $this
            ->actingAs($this->user)
            ->json('put', route('company.update', $this->company), $company->getAttributes());

        //$response->dump();
        $response->assertOk();
    }
}
