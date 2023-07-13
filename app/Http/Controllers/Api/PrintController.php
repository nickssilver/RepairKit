<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\RepairDispatchPrintResource;
use App\Http\Resources\RepairOrderPrintResource;
use App\Models\RepairOrder;
use Illuminate\Http\JsonResponse;

class PrintController extends ApiController
{

    /**
     * Repair order printing
     *
     * @param RepairOrder $repairOrder repairOrder
     *
     * @return JsonResponse
     */
    public function repair(RepairOrder $repairOrder): JsonResponse
    {
        return response()->json(
            [
                'repair' => new RepairOrderPrintResource($repairOrder),
            ]
        );
    }

    /**
     * Prints dispatch information
     *
     * @param      \App\Models\RepairOrder  $repairOrder  The repair order
     *
     * @return     JsonResponse             The json response.
     */
    public function dispatchInfo(RepairOrder $repairOrder): JsonResponse
    {
        return response()->json(
            [
                'repair' => new RepairDispatchPrintResource($repairOrder),
            ]
        );
    }
}
