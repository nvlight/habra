<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return CompanyResource::collection(Company::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request): Company
    {
        $attributes = $request->validated();

        /** @var Company $company */
        $company = Company::query()->create($attributes);

        return $company;
    }

    /**
     * Display the specified resource.
//     * @throws CompanyNotFoundException
     */
    public function show(Company $company): array
    {
        return (new CompanyResource($company))->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company): Company
    {
        //Gate::allowIf(fn(User $user) => $company->isOwnedBy($user));

        $attributes = $request->validated();

        ($company)->update($attributes);

        return $company;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): void
    {
        Gate::allowIf(fn(User $user) => $company->isOwnedBy($user));

        $company->delete();
    }
}
