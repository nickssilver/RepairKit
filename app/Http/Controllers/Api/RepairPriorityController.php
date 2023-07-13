<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\PriorityRequest;
use App\Http\Resources\RepairPriorityResource as PriorityResource;
use App\Models\RepairPriority as Priority;
use Illuminate\Http\JsonResponse;

class RepairPriorityController extends ApiController
{

    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Repair priorities list
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $priorities = Priority::orderBy('value')->get();
        return response()->json(PriorityResource::collection($priorities));
    }

    public function store(PriorityRequest $request): JsonResponse
    {
        $repairPriority = Priority::create($request->validated());
        return response()->json(
            [
                'message'  => __('Data updated successfully'),
                'priority' => $repairPriority,
            ]
        );
    }

    /**
     * Display specific repair priority
     *
     * @param Priority $repairPriority repairPriority
     *
     * @return JsonResponse
     */
    public function show(Priority $repairPriority): JsonResponse
    {
        return response()->json(new PriorityResource($repairPriority));
    }

    /**
     * Update specific repair priority
     *
     * @param PriorityRequest $request request
     * @param Priority      $repairPriority repairPriority
     *
     * @return JsonResponse
     */
    public function update(PriorityRequest $request, Priority $repairPriority): JsonResponse
    {
        $repairPriority->update($request->validated());
        return response()->json(
            [
                'message'  => __('Data updated successfully'),
                'priority' => new PriorityResource($repairPriority),
            ]
        );
    }

    /**
     * Destroys the given repair priority.
     *
     * @param      Priority      $repairPriority  The repair priority
     *
     * @return     JsonResponse  The json response.
     */
    public function destroy(Priority $repairPriority): JsonResponse
    {
        if ($repairPriority->beingUsed()) {
            return response()->json(
                ['message' => __('Unable to delete data is being used')]
            );
        }
        $repairPriority->delete();
        return response()->json(
            [
                'message' => __('Data removed successfully'),
            ]
        );
    }
}
