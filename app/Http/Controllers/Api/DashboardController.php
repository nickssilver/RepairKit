<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Brand;
use App\Models\Defect;
use App\Models\Device;
use App\Models\RepairOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Dashboard states
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function states(Request $request): JsonResponse
    {
        $repairs = collect(RepairOrder::filter($request->all())->get());
        return response()->json(
            [
                'amount'  => $repairs->sum('total_charges'),
                'cost'    => $repairs->sum('total_cost'),
                'tax'     => $repairs->sum('tax'),
                'profit'  => $repairs->sum('profit'),
                'orders'  => $repairs->count(),
                'brands'  => Brand::count(),
                'devices' => Device::count(),
                'defects' => Defect::count(),
            ]
        );
    }

    /**
     * Dashboard annual graph
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function annualGraph(Request $request): JsonResponse
    {
        $graph = [];
        $month = 1;
        while ($month <= 12) {
            $graph[] = RepairOrder::filter($request->all())
                ->whereMonth('created_at', '=', $month)
                ->count();
            $month++;
        }
        return response()->json($graph);
    }
}
