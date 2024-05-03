<?php

namespace Feature\Api\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyCompanyTest extends TestCase
{
    use RefreshDatabase;

    private Company $company;

    private User $user;

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
    public function test_destroy_company(): void
    {
        // sail artisan test --filter=DestroyCompanyTest

        $this->withoutExceptionHandling();

        $response = $this
            ->actingAs($this->user)
            ->delete(route('company.destroy', $this->company));

        $response->assertOk();
    }
}
