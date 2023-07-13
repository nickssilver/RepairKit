<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\RepairReportResource;
use App\Models\RepairOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends ApiController
{

    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function generate(Request $request): JsonResponse
    {
        $orders = RepairOrder::filter($request->all())->get();
        $collection = collect($orders);
        return response()->json(
            [
                'amount' => $collection->sum('total_charges'),
                'cost' => $collection->sum('total_cost'),
                'tax' => $collection->sum('tax'),
                'profit' => $collection->sum('profit'),
                'orders' => $collection->count(),
                'list' => RepairReportResource::collection($orders),
            ]
        );
    }
}
