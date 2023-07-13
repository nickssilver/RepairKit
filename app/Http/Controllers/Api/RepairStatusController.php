<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\RepairStatusRequest;
use App\Http\Resources\RepairStatusResource as StatusResource;
use App\Models\RepairStatus as Status;
use Illuminate\Http\JsonResponse;

class RepairStatusController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Repair statuses
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $statuses = Status::latest()->get();
        return response()->json(StatusResource::collection($statuses));
    }

    /**
     * Display specific repair status
     *
     * @param Status $repairStatus repairStatus
     *
     * @return JsonResponse
     */
    public function show(Status $repairStatus): JsonResponse
    {
        return response()->json(new StatusResource($repairStatus));
    }

    /**
     * Store repair statuses
     *
     * @param      \App\Http\Requests\RepairStatusRequest  $request  The request
     *
     * @return     JsonResponse                            The json response.
     */
    public function store(RepairStatusRequest $request): JsonResponse
    {
        $repairStatus = Status::create($request->validated());
        return response()->json(
            [
                'message' => __('Data updated successfully'),
                'status'  => $repairStatus,
            ]
        );
    }

    /**
     * Update specific repair status
     *
     * @param RepairStatusRequest $request      request
     * @param Status        $repairStatus repairStatus
     *
     * @return JsonResponse
     */
    public function update(RepairStatusRequest $request, Status $repairStatus): JsonResponse
    {
        $repairStatus->update($request->validated());
        return response()->json(
            [
                'message' => __('Data updated successfully'),
            ]
        );
    }

    /**
     * Destroys the given repair status.
     *
     * @param      Status        $repairStatus  The repair status
     *
     * @return     JsonResponse  The json response.
     */
    public function destroy(Status $repairStatus): JsonResponse
    {
        if ($repairStatus->beingUsed()) {
            return response()->json(
                ['message' => __('Unable to delete data is being used')]
            );
        }
        $repairStatus->delete();
        return response()->json(
            [
                'message' => __('Data removed successfully'),
            ]
        );
    }
}
