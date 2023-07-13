<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ContactUsRequest;
use App\Mail\ContactUsMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class SupportController extends ApiController
{
    public function __construct()
    {
        $this->middleware('captcha');
    }

    /**
     * Public desk support
     *
     * @param ContactUsRequest     $request     request
     * @return JsonResponse
     */
    public function contactUs(ContactUsRequest $request): JsonResponse
    {
        Mail::to($this->master()->mail_from_address)->send(new ContactUsMail($request->validated()));
        return response()->json(
            ['message' => __('Thank you for getting in touch, we always try our best to respond as soon as possible, you can expect a reply in at most 48 hours')]
        );
    }
}
