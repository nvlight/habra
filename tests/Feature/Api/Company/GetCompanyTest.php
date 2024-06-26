<?php

namespace Feature\Api\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCompanyTest extends TestCase
{
    use RefreshDatabase;

    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()
            ->for(User::factory(), 'spokesperson')
            ->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_company(): void
    {
        // sail artisan test --filter=GetCompanyTest

        $response = $this->get(route('company.show', $this->company->id));

        $response->assertOk();

        $response->assertJsonIsObject();

        $response->assertJsonStructure([
            "id",
            "spokesperson_id",
            "name",
            "title",
            "site",
            "age_date",
            "numbers",
            "location",
        ]);

        $response->assertJson([
            "id" => $this->company->id,
            "spokesperson_id" => $this->company->spokesperson_id,
            "name" => $this->company->name,
            "title" => $this->company->title,
            "site" => $this->company->site,
            "age_date" => $this->company->age_date,
            "numbers" => $this->company->numbers,
            "location" => $this->company->location,
        ]);
    }
}
