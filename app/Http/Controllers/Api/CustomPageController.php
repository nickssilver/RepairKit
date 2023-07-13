<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CustomPageStoreRequest;
use App\Http\Requests\CustomPageUpdateRequest;
use App\Http\Resources\CustomPageDetailResource;
use App\Http\Resources\CustomPageResource;
use App\Models\CustomPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomPageController extends ApiController
{

    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('customPageList', 'readBySlug');
        $this->middleware(
            'demo',
            ['only' => ['store', 'update', 'destroy']]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort    = $this->sort($request);
        $replies = CustomPage::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));

        return response()->json(
            [
                'items'      => CustomPageResource::collection($replies->items()),
                'pagination' => $this->pagination($replies),
            ]
        );
    }

    /**
     * Store to database
     *
     * @param CustomPageStoreRequest $request request
     *
     * @return JsonResponse
     */
    public function store(CustomPageStoreRequest $request): JsonResponse
    {
        $page = CustomPage::create($this->validatedPage($request));
        return response()->json(
            [
                'message'    => __('Data saved successfully'),
                'customPage' => new CustomPageResource($page),
            ]
        );
    }

    /**
     * Display specific resource
     *
     * @param CustomPage $customPage CustomPage
     *
     * @return JsonResponse
     */
    public function show(CustomPage $customPage): JsonResponse
    {
        return response()->json(new CustomPageDetailResource($customPage));
    }

    /**
     * Update specific resource
     *
     * @param CustomPageUpdateRequest $request    request
     * @param CustomPage    $customPage CustomPage
     *
     * @return JsonResponse
     */
    public function update(CustomPageUpdateRequest $request, CustomPage $customPage): JsonResponse
    {
        $customPage->update($this->validatedPage($request));
        return response()->json(
            ['message' => __('Data updated successfully')],
            200
        );
    }

    /**
     * Destroy specific resource
     *
     * @param CustomPage $customPage CustomPage
     *
     * @return JsonResponse
     */
    public function destroy(CustomPage $customPage): JsonResponse
    {
        $customPage->delete();
        return response()->json(
            ['message' => __('Data removed successfully')]
        );
    }

    protected function validatedPage($request): array
    {
        $validated         = $request->validated();
        $validated['slug'] = \Str::slug($request->title);
        return $validated;
    }
}
