<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\SettingController;
use App\Http\Requests\SMSGatewayRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SmsGatewaysController extends SettingController
{
    /**
     * Construct middleware and initialize master app settings
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo')->only(
            [
                'setSmsApi',
            ]
        );
        $this->settings   = $this->master();
        $this->collection = collect($this->settings);
    }

    /**
     * Gets the sms api.
     *
     * @return     JsonResponse  The sms api.
     */
    public function getSmsApi(): JsonResponse
    {
        return response()->json(
            $this->collection->only(
                [
                    'sms_status', 'sms_channel',
                    'nexmo_key', 'nexmo_secret', 'nexmo_from',
                    'twilio_account_sid', 'twilio_auth_token', 'twilio_from',
                ]
            )
        );
    }

    /**
     * Sets the sms api.
     *
     * @param      \App\Http\Requests\SMSGatewayRequest  $braintree  The braintree
     *
     * @return     JsonResponse                          The json response.
     */
    public function setSmsApi(SMSGatewayRequest $sms): JsonResponse
    {
        $this->settings->update($sms->validated());
        return response()->json(
            ['message' => __('Settings updated successfully')]
        );
    }
}
