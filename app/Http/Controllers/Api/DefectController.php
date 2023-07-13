<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\DefectRequest;
use App\Http\Resources\DefectDetailResource;
use App\Http\Resources\DefectResource;
use App\Http\Resources\DeviceSelectResource;
use App\Models\Defect;
use App\Models\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DefectController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware(
            'demo',
            ['only' => ['store', 'update', 'destroy', 'sync']]
        );
    }

    /**
     * Defect list
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sort  = $this->sort($request);
        $items = Defect::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));

        return response()->json(
            [
                'items'      => DefectResource::collection($items->items()),
                'pagination' => $this->pagination($items),
            ]
        );
    }

    /**
     * Store defect
     *
     * @param DefectRequest $request request
     *
     * @return JsonResponse
     */
    public function store(DefectRequest $request): JsonResponse
    {
        $defect = Defect::create($request->validated());
        return response()->json(
            [
                'message' => __('Data updated successfully'),
                'defect'  => new DefectDetailResource($defect),
            ]
        );
    }

    /**
     * Display specific resource
     *
     * @param Defect $defect defect
     *
     * @return JsonResponse
     */
    public function show(Defect $defect): JsonResponse
    {
        $defects = Device::latest()->get();
        return response()->json(
            [
                'device_list' => DeviceSelectResource::collection($defects),
                'defect'      => new DefectDetailResource($defect),
            ]
        );
    }

    /**
     * Update specific resource
     *
     * @param DefectRequest $request request
     * @param Defect        $defect  defect
     *
     * @return JsonResponse
     */
    public function update(DefectRequest $request, Defect $defect): JsonResponse
    {
        $defect->update($request->validated());
        return response()->json(['message' => __('Data updated successfully')]);
    }

    /**
     * Destroy specific resource
     *
     * @param Defect $defect defect
     *
     * @return JsonResponse
     */
    public function destroy(Defect $defect): JsonResponse
    {
        if ($defect->beingUsed()) {
            return response()->json(
                ['message' => __('Unable to delete data is being used')]
            );
        }
        $defect->delete();
        return response()->json(['message' => __('Data removed successfully')]);
    }
}
