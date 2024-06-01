<?php

namespace Feature\Api\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateCompanyTest extends TestCase
{
    use RefreshDatabase;

    private string $routePrefix = 'company.';
    private Company $existingCompany;
    private Company $newCompany;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->existingCompany = Company::factory()
            ->for($this->user, 'spokesperson')
            ->create();

        $this->newCompany = Company::factory()
            ->for($this->user, 'spokesperson')
            ->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_update_company(): void
    {
        // sail artisan test --filter=UpdateCompanyTest

        $this->withoutExceptionHandling();

        //$response = $this->actingAs($this->user)
        //    ->post(route('post.update', $this->post), $post->getAttributes())
        //    //->assertSessionHasNoErrors() // эта штука также выдает ошибку!
        //;

//        $response = $this
//            ->actingAs($this->user)
//            ->json('put', route('company.update', $this->company), $company->getAttributes());

        $response = $this->actingAs($this->user)
            ->putJson(
                route($this->routePrefix . 'update', $this->existingCompany),
                $this->newCompany->toArray()
            );

        $response->assertJson([
            'id' => $this->existingCompany->id,
            'name' => $this->newCompany->name,
            'title' => $this->newCompany->title,
        ]);

        $this->assertDatabaseHas(
            'companies',
            $this->newCompany->toArray(),
        );

        $response->assertOk();
    }
}
