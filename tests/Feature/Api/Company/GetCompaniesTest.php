<?php

namespace Feature\Api\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCompaniesTest extends TestCase
{
    use RefreshDatabase;

    private Collection $companies;

    protected function setUp(): void
    {
        parent::setUp();

        $this->companies = Company::factory(5)
            ->for(User::factory(), 'spokesperson')
            ->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_companies(): void
    {
        // sail artisan test --filter=GetCompaniesTest

        $response = $this->get(route('company.index'));

        $response->assertOk();

        $response->assertJsonIsArray();

        $response->assertJsonStructure([
            '*' => [
                "id",
                "spokesperson_id",
                "name",
                "title",
                "site",
                "age_date",
                "numbers",
                "location",
            ]
        ]);
    }
}
