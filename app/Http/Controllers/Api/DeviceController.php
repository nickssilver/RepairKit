<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\DeviceStoreRequest;
use App\Http\Requests\DeviceUpdateRequest;
use App\Http\Resources\BrandSelectResource;
use App\Http\Resources\DeviceDetailResource;
use App\Http\Resources\DeviceResource;
use App\Http\Resources\DeviceSelectResource;
use App\Models\Brand;
use App\Models\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends ApiController
{

    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Device list
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sort = $this->sort($request);

        $devices = Device::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));

        return response()->json(
            [
                'items' => DeviceResource::collection($devices->items()),
                'pagination' => $this->pagination($devices),
            ]
        );
    }

    /**
     * Store to database
     *
     * @param DeviceStoreRequest $request request
     *
     * @return JsonResponse
     */
    public function store(DeviceStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->file('avatar')) {
            $validated['avatar'] = $request->file('avatar')
                ->store('repairing/device', 'public');
        }

        $device = Device::create($validated);
        return response()->json(
            [
                'message' => __('Data updated successfully'),
                'device' => new DeviceResource($device),
            ]
        );
    }

    /**
     * Display specific resource
     *
     * @param Device $device device
     *
     * @return JsonResponse
     */
    public function show(Device $device): JsonResponse
    {
        $brands = Brand::latest()->get();
        return response()->json(
            [
                'device' => new DeviceDetailResource($device),
                'brand_list' => BrandSelectResource::collection($brands),
            ]
        );
    }

    /**
     * Update specific resource
     *
     * @param DeviceUpdateRequest $request request
     * @param Device        $device  device
     *
     * @return JsonResponse
     */
    public function update(DeviceUpdateRequest $request, Device $device): JsonResponse
    {
        $validated = $request->validated();
        if ($request->file('avatar')) {
            $validated['avatar'] = $request->file('avatar')
                ->store('repairing/device', 'public');
        }
        $device->update($validated);
        return response()->json(['message' => __('Data updated successfully')]);
    }

    /**
     * Destroy specific resource
     *
     * @param Device $device device
     *
     * @return JsonResponse
     */
    public function destroy(Device $device): JsonResponse
    {
        if ($device->beingUsed()) {
            return response()->json(
                ['message' => __('Unable to delete data is being used')]
            );
        }
        $device->delete();
        return response()->json(['message' => __('Data removed successfully')]);
    }

    /**
     * Device list for forms drop down
     *
     * @return JsonResponse
     */
    public function deviceList(): JsonResponse
    {
        $latestDevices = Device::latest()->get();
        return response()->json(DeviceSelectResource::collection($latestDevices));
    }
}
