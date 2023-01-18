<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $companies = Company::all();
        return responseJson('', [
            'categories' => $companies,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $validator->validate();
        $validated = $validator->safe()->all();
        $company = Company::create($validated);
        return responseJson('company created successfully', [
            'company' => $company,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return JsonResponse
     */
    public function show(Company $company): JsonResponse
    {
        return responseJson('', [
            'company' => $company,
        ]);
    }
    public function employees(Company $company): JsonResponse
    {
        return responseJson('', [
            'employees' => $company->employees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Company $company
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Company $company): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required',
        ]);
        $validator->validate();
        $validated = $validator->safe()->all();
        $company->update($validated);
        return responseJson('company updated successfully', [
            'company' => $company,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return JsonResponse
     */
    public function destroy(Company $company): JsonResponse
    {
        $company->delete();
        return responseJson('company deleted successfully', [
            'company' => $company,
        ]);

    }
}
