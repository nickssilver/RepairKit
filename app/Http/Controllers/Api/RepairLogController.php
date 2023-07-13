<?php

namespace App\Http\Controllers\Api;

use App\Events\RepairOrderStatusUpdatedEvent;
use App\Http\Controllers\ApiController;
use App\Http\Requests\RepairLogRequest;
use App\Models\RepairLog;
use Illuminate\Http\JsonResponse;

class RepairLogController extends ApiController
{

    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Repairing log saves to database
     *
     * @param RepairLogRequest $request request
     *
     * @return JsonResponse
     */
    public function store(RepairLogRequest $request): JsonResponse
    {
        $log = RepairLog::create($request->validated());
        if (!$log) {
            return response()->json(
                ['message' => __('Something went wrong try again !')],
                500
            );
        }

        $log->repairOrder()->update(['repair_status_id' => $request->status_id]);

        if ($request->notify) {
            RepairOrderStatusUpdatedEvent::dispatch($log->repairOrder, $log->repairOrder->repairStatus->body, $this->master()->getNotificationConfig($log->repairOrder));
        }

        return response()->json(['message' => __('Data saved successfully')]);
    }
}
