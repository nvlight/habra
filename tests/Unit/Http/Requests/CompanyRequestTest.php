<?php

namespace Unit\Http\Requests;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase as tc;
use Tests\TestCase;

class CompanyRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $routePrefix = 'company.';

    public function test_name_is_required()
    {
        // sail artisan test --filter=CompanyRequestTest
        //$this->withoutExceptionHandling();

        $validatedField = 'name';
        $brokenRule = null;

        $spokesPerson = User::factory()->create();
        $property = Company::factory()
            ->for($spokesPerson, 'spokesperson')
            ->make([
                $validatedField => $brokenRule
            ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $property->toArray()
        )
            ->assertJsonValidationErrors($validatedField);

    }

    public function test_name_must_not_exceed_155_characters()
    {
        // sail artisan test --filter=CompanyRequestTest
        //$this->withoutExceptionHandling();

        $validatedField = 'name';
        $brokenRule = Str::random(156);

        $spokesPerson = User::factory()->create();
        $property = Company::factory()
            ->for($spokesPerson, 'spokesperson')
            ->make([
                $validatedField => $brokenRule
            ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $property->toArray()
        )
            ->assertJsonValidationErrors($validatedField);

    }

    public function test_spokesperson_id_is_required()
    {
        // sail artisan test --filter=CompanyRequestTest
        // $this->withoutExceptionHandling();

        $validatedField = 'spokesperson_id';
        $brokenRule = null;

        $spokesPerson = User::factory()->create();
        $property = Company::factory()
            ->for($spokesPerson, 'spokesperson')
            ->make([
                $validatedField => $brokenRule
            ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $property->toArray()
        )
            ->assertJsonValidationErrors($validatedField);

    }

    public function test_numbers_must_be_integer()
    {
        // sail artisan test --filter=CompanyRequestTest
        // $this->withoutExceptionHandling();

        $validatedField = 'numbers';
        $brokenRule = 'not-integer---df33';

        $spokesPerson = User::factory()->create();
        $property = Company::factory()
            ->for($spokesPerson, 'spokesperson')
            ->make([
                $validatedField => $brokenRule
            ]);

        $this->postJson(
            route($this->routePrefix . 'store'),
            $property->toArray()
        )
            ->assertJsonValidationErrors($validatedField);

    }
}
