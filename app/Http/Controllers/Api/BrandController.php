<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\BrandSelectResource;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;

class BrandController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(BrandResource::collection(Brand::latest()->get()));
    }

    /**
     * Store to database
     *
     * @param BrandStoreRequest $request request
     *
     * @return JsonResponse
     */
    public function store(BrandStoreRequest $request): JsonResponse
    {
        $brand = Brand::create($request->validated());
        return response()->json(
            [
                'message' => __('Data saved successfully'),
                'brand' => new BrandResource($brand),
            ]
        );
    }

    /**
     * Display specific brand
     *
     * @param Brand $brand brand
     *
     * @return JsonResponse
     */
    public function show(Brand $brand): JsonResponse
    {
        return response()->json(new BrandResource($brand));
    }

    /**
     * Update specific brand information
     *
     * @param BrandUpdateRequest $request request
     * @param Brand         $brand   brand
     *
     * @return JsonResponse
     */
    public function update(BrandUpdateRequest $request, Brand $brand): JsonResponse
    {
        $brand->update($request->validated());
        return response()->json(['message' => __('Data updated successfully')]);
    }

    /**
     * Destroy brand
     *
     * @param Brand $brand brand
     *
     * @return JsonResponse
     */
    public function destroy(Brand $brand): JsonResponse
    {
        if ($brand->beingUsed()) {
            return response()->json(
                ['message' => __('Unable to delete data is being used')]
            );
        }
        $brand->delete();
        return response()->json(['message' => __('Data removed successfully')]);
    }

    /**
     * Brand list from database
     *
     * @return JsonResponse
     */
    public function brandList(): JsonResponse
    {
        return response()->json(
            BrandSelectResource::collection(Brand::latest()->get())
        );
    }
}
