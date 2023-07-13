<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\QuickReplyRequest;
use App\Http\Resources\QuickReplyListResource;
use App\Http\Resources\QuickReplyResource;
use App\Models\QuickReply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuickReplyController extends ApiController
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
     * Quick replies for management
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sort    = $this->sort($request);
        $replies = QuickReply::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));

        return response()->json(
            [
                'items'      => QuickReplyResource::collection($replies->items()),
                'pagination' => $this->pagination($replies),
            ]
        );
    }

    /**
     * Store to database
     *
     * @param QuickReplyRequest $request request
     *
     * @return JsonResponse
     */
    public function store(QuickReplyRequest $request): JsonResponse
    {
        $quickReply = QuickReply::create($request->validated());
        return response()->json(
            [
                'message'    => __('Data saved successfully'),
                'quickReply' => new QuickReplyResource($quickReply),
            ]
        );
    }

    /**
     * Display specific resource
     *
     * @param QuickReply $quickReply quickReply
     *
     * @return JsonResponse
     */
    public function show(QuickReply $quickReply): JsonResponse
    {
        return response()->json(new QuickReplyResource($quickReply));
    }

    /**
     * Update specific resource
     *
     * @param QuickReplyRequest $request    request
     * @param QuickReply    $quickReply quickReply
     *
     * @return JsonResponse
     */
    public function update(QuickReplyRequest $request, QuickReply $quickReply): JsonResponse
    {
        $quickReply->update($request->validated());
        return response()->json(
            ['message' => __('Data updated successfully')],
            200
        );
    }

    /**
     * Destroy specific resource
     *
     * @param QuickReply $quickReply quickReply
     *
     * @return JsonResponse
     */
    public function destroy(QuickReply $quickReply): JsonResponse
    {
        $quickReply->delete();
        return response()->json(
            ['message' => __('Data removed successfully')]
        );
    }

    /**
     * Quick replies list form storage.
     *
     * @return JsonResponse
     */
    public function quickRepliesList(): JsonResponse
    {
        $replies = QuickReply::latest()->get();
        return response()->json(QuickReplyListResource::collection($replies));
    }
}
