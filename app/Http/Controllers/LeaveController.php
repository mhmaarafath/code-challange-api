<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $leaves = Leave::all();
        return responseJson('', [
            'leaves' => $leaves,
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
        $employee = Employee::find($request->employee_id);
        if($employee){
            $leaves_available = $employee->leaves_available;
            if($leaves_available > 0){
                $days = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;
                if($leaves_available > $days){
                    $validator = Validator::make($request->all(), [
                        'start_date' => 'required|date',
                        'end_date' => 'required|date',
                        'leave_reason' => 'required',
                        'employee_id' => [
                            'required',
                            'exists:App\Models\Employee,id'
                        ],
                    ]);
                    $validator->validate();
                    $validated = $validator->safe()->all();
                    $leave = Leave::create($validated);
                    return responseJson('leave created successfully', [
                        'leave' => $leave,
                    ]);
                } else {
                    return responseJson("remaining ${leaves_available}");
                }
            } else {
                return responseJson("not eligible for leaves");
            }
        }else{
            return responseJson('employee not found');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param Leave $leave
     * @return JsonResponse
     */
    public function show(Leave $leaf): JsonResponse
    {
        return responseJson('', [
            'leave' => $leaf,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Leave $leave
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Leave $leaf)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'sometimes|required',
            'end_date' => 'sometimes|required',
            'leave_reason' => 'sometimes|required',
            'employee_id' => [
                'sometimes',
                'required',
                'exists:App\Models\Employee,id'
            ],
        ]);
        $validator->validate();
        $validated = $validator->safe()->all();
        $leaf->update($validated);
        return responseJson('leave edited successfully', [
            'leave' => $leaf,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Leave $leave
     * @return JsonResponse
     */
    public function destroy(Leave $leaf): JsonResponse
    {
        $leaf->delete();
        return responseJson('leave deleted successfully', [
            'leave' => $leaf,
        ]);

    }
}
