<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $employees = Employee::all();
        return responseJson('', [
            'employees' => $employees,
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
            'profile_photo' => 'nullable',
            'company_id' => [
                'required',
                'exists:App\Models\Company,id'
            ],
            'dob' => 'required',
            'emirates_id' => 'nullable',
            'contract_start_date' => 'required',
        ]);
        $validator->validate();
        $validated = $validator->safe()->except('profile_photo');
        if ($request->hasFile('profile_photo')) {
            $path = Storage::put('public/avatar', $request->file('profile_photo'));
            $validated['profile_photo'] = $path;
        }
        $employee = Employee::create($validated);
        return responseJson('employee created successfully', [
            'employee' => $employee,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return JsonResponse
     */
    public function show(Employee $employee): JsonResponse
    {
        return responseJson('', [
            'employee' => $employee,
        ]);
    }

    public function leaves(Employee $employee): JsonResponse
    {
        return responseJson('', [
            'leaves' => $employee->leaves,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Employee $employee
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Employee $employee): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required',
            'profile_photo' => 'nullable',
            'company_id' => [
                'sometimes',
                'required',
                'exists:App\Models\Company,id'
            ],
            'dob' => 'sometimes|required',
            'emirates_id' => 'nullable',
            'contract_start_date' => 'sometimes|required',
        ]);
        $validator->validate();
        $validated = $validator->safe()->except('profile_photo');
        if ($request->hasFile('profile_photo')) {
            $path = Storage::put('public/avatar', $request->file('profile_photo'));
            $validated['profile_photo'] = $path;
        }
        $employee->update($validated);
        return responseJson('employee updated successfully', [
            'employee' => $employee,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return JsonResponse
     */
    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();
        return responseJson('employee deleted successfully', [
            'employee' => $employee,
        ]);

    }
}
