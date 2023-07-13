<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FAQRequest;
use App\Http\Resources\FAQResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('faqList');
        $this->middleware(
            'demo',
            ['only' => ['store', 'update', 'destroy']]
        );
    }

    /**
     * Frequently asked questions
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(FAQResource::collection(Faq::get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FAQRequest  $request
     * @return JsonResponse
     */
    public function store(FAQRequest $request): JsonResponse
    {
        $faq = Faq::create($request->validated());
        return response()->json(
            [
                'message' => __('Data saved successfully'),
                'faq'     => new FAQResource($faq),
            ]
        );
    }

    /**
     * Display specific faq
     *
     * @param Faq $faq faq
     *
     * @return JsonResponse
     */
    public function show(Faq $faq): JsonResponse
    {
        return response()->json(new FAQResource($faq));
    }

    /**
     * Update specific repair status
     *
     * @param FAQRequest $request      request
     * @param Faq        $faq faq
     *
     * @return JsonResponse
     */
    public function update(FAQRequest $request, Faq $faq): JsonResponse
    {
        $faq->update($request->validated());
        return response()->json(
            [
                'message' => __('Data updated successfully'),
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return JsonResponse
     */
    public function destroy(Faq $faq): JsonResponse
    {
        $faq->delete();
        return response()->json(
            ['message' => __('Data removed successfully')]
        );
    }
}
